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
                 "productId"=>$p['id'],
                 "productName"=>$p['name'],
                 "productImage"=>$p['image'],
                 "quantity"=>1,
                 "price"=>$p['promotionPrice']
             );
             echo '<script>alert("Thêm sản phẩm vào giỏ hàng thành công!");window.history.back();</script>';
         }
    }

    public function checkout() {
        // Hiển thị trang xem giỏ hàng
        $this->view('/client/checkout',[
            "headTitle"=>"Xem giỏ hàng"
        ]);
    }

    public function removeItemCart($productId) {
        //Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$productId]);
        //Kiểm tra sản phẩm đã xóa chưa
        if (!isset($_SESSION['cart'][$productId])) {
            echo '<script>alert("Xóa sản phẩm thành công!");window.history.back();</script>';
         }
    } 

    public function getTotalQuantityCart() {
        //Kiểm tra giỏ hàng có tồn tại chưa
        $total = 0;
        if (isset($_SESSION['cart'])) {
            // Duyệt từng sản phẩm để cộng vào total
            foreach($_SESSION['cart'] as $key => $value) {
                $total += $value['quantity'];
            }
            return $total;
        }
    }

    public function updateItemCart($productId, $qty) {
        // Khởi tạo model để gọi các hàm
        $product = $this->model('ProductModel');
        // gọi hàm checkQuantity để kiểm tra số lượng tồn
        $check = $product->checkQuantity($productId, $qty);
        if ($check) {
            // cập nhật số lượng sản phẩm
            $_SESSION['cart'][$productId]['quantity'] = $qty;
            // Trả về OK
            http_response_code(200);
        }else {
            // Trả về lỗi 501 not emplemented
            http_response_code(501);
        }
    }
}
