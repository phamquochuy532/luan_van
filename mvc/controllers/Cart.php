<?php
class Cart extends ControllerBase{
    public function addItemCart($productId){
         // Khởi tạo model
         $product = $this->model("ProductModel");
         // Kiểm tra sản phẩm có tồn tại trong giỏ hàng chưa
         // Nếu tồn tại thì + số lượng lên 1 đơn vị
         // Nếu chưa tồn tại thì thêm mới sản phẩm vào giỏ hàng
         if (isset($_SESSION['cart'][$productId])) {
             //Kiểm tra số lượng tồn kho
            $check = $product->checkQuantity($productId,$_SESSION['cart'][$productId]['quantity']);
            if ($check){
                $_SESSION['cart'][$productId]['quantity']++;
                echo '<script>alert("Thêm sản phẩm vào giỏ hàng thành công!");window.history.back();</script>';
            }else {
                echo '<script>alert("Số lượng sản phẩm không đủ để thêm vào giỏ!");window.history.back();</script>';
            }
         }else {
             //Lấy ra sản phẩm để btheem vào giỏ hàng
             $result = $product->getById($productId);
             //fetch
             $p = $result->fetch_assoc();
             //Thêm sản phẩm vào giỏ hàng
             $_SESSION['cart'][$p['id']] = array(
                 "productName"=>$p['name'],
                 "productimage"=>$p['image'],
                 "quantity"=>1,
                 "price"=>$p['promotionPrice']
             );
             echo '<script>alert("Thêm sản phẩm vào giỏ hàng thành công!");window.history.back();</script>';
         }
    }

    public function checkout() {
        $this->view('checkout',[
            "headTitle"=>"Xem giỏ hàng"
        ]);
    }
}
?>