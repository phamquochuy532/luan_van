<?php
class Home extends ControllerBase{
    public function Index(){
        // Khởi tạo model để gọi các hàm
        $product = $this->model("ProductModel");
        // Gọi hàm getFeaturedProducts để lấy ra các sản phẩm nổi bật
        $result = $product->getFeaturedProducts();


        // Fetch
        $productList = $result->fetch_all(MYSQLI_ASSOC);
        $this->view("/client/index", [
            // Hiển thị trang chủ
            "headTitle" => "Trang chủ",
            "productList" => $productList

        ]);
    }
}
?>