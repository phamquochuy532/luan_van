<?php
class Home extends ControllerBase{
    public function Index(){
        // Khởi tạo model để gọi các hàm
        $product = $this->model("ProductModel");
        // Gọi hàm getFeaturedProducts để lấy ra các sản phẩm nổi bật
        $result = $product->getFeaturedProducts();

        // Khởi tạo model để gọi các hàm
        $category = $this->model("CategoryModel");
        // Gọi hàm getAllClient để lấy ra danh sách danh mục để hiện thị lên menu
        $cates = $category->getAllClient();
        // Fetch
        $productList = $result->fetch_all(MYSQLI_ASSOC);
        $this->view("index", [
            // Hiển thị trang chủ
            "headTitle" => "Trang chủ",
            "productList" => $productList,
            "cates" => $cates
        ]);
    }
}
?>