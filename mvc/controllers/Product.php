<?php

class Product extends ControllerBase
{

    public function single($Id)
    {
        // Khởi tạo model để gọi các hàm
        $product = $this->model("ProductModel");
        // Gọi hàm getById (tham số Id) để lấy sản phẩm theo mã
        $result = $product->getById($Id);
        // Fetch
        $p = $result->fetch_assoc();

        // Khởi tạo model để gọi các hàm
        $category = $this->model("CategoryModel");
        // Gọi hàm getAllclient để lấy ra dữ liệu hiển thị lên menu
        $cates = $category->getAllClient();

        // Hiển thị trang single
        $this->view("/client/single", [
            "headTitle" => $p['name'],
            "product" => $p,
            "cates" => $cates
        ]);
    }
     public function search()
     {
         // Tạo biến để lưu giá trị từ form
         $keyword = $_POST['keyword'];
         // Khởi tạo model để gọi các hàm
         $product = $this->model('ProductModel');
         // Gọi hàm search (tham số keyword)
         $result = $product->search($keyword);
         // Đọc dữ liệu
         $productList = $result->fetch_all(MYSQLI_ASSOC);
         
         // Khởi tạo model để gọi các hàm
        $category = $this->model("CategoryModel");
        // Gọi hàm getAllclient để lấy ra dữ liệu hiển thị lên menu
        $cates = $category->getAllClient();

        // Hiển thị tragn products
         $this->view('/client/products',[
             "headTitle" => "Tìm kiếm",
             "title" => "Tìm kiếm với từ khóa: ". $keyword,
             "productList" => $productList,
             "cates" => $cates
         ]);
     }

     public function category($CateId) {
         // Khỏi tạo model để gọi các hàm
        $product = $this->model('ProductModel');
        // Gọi hàm getByCateId (tham số CateId)
        $result = $product->getByCateId($CateId);

        // Khởi tạo model để gọi các hàm
        $category = $this->model('CategoryModel');
        // Đọc dữ liệu
        $cate = ($category->getById($CateId))->fetch_assoc();
        // Gọi hàm getAllclient để lấy ra dữ liệu hiển thị lên menu
        $cates = $category->getAllClient();
        
        //fetch
        $productList = $result->fetch_all(MYSQLI_ASSOC);
        // Hiển thị trang category
        $this->view('/client/category',[
            "headTitle" =>"Danh mục " .$cate['name'],
            "title" =>"Danh mục " .$cate['name'],
            "productList" =>$productList,
            "cates" => $cates,
        ]);
     }
}
