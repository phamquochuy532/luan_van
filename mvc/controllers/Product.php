<?php

class Product extends ControllerBase
{

    public function single($Id)
    {
        $product = $this->model("ProductModel");
        $result = $product->getById($Id);
        // Fetch
        $p = $result->fetch_assoc();

        $category = $this->model("CategoryModel");
        $cates = $category->getAllClient();

        $this->view("single", [
            "headTitle" => $p['name'],
            "product" => $p,
            "cates" => $cates
        ]);
    }
     public function search()
     {
         $keyword = $_POST['keyword'];
         $product = $this->model('ProductModel');
         $result = $product->search($keyword);
         $productList = $result->fetch_all(MYSQLI_ASSOC);
         
        $category = $this->model("CategoryModel");
        $cates = $category->getAllClient();

         $this->view('products',[
             "headTitle" => "Tìm kiếm",
             "title" => "Tìm kiếm với từ khóa: ". $keyword,
             "productList" => $productList,
             "cates" => $cates
         ]);
     }

     public function category($CateId) {
        $product = $this->model('ProductModel');
        $result = $product->getByCateId($CateId);

        $category = $this->model('CategoryModel');
        $cate = ($category->getById($CateId))->fetch_assoc();
        $cates = $category->getAllClient();
        
        //fetch

        $productList = $result->fetch_all(MYSQLI_ASSOC);
        $this->view('category',[
            "headTitle" =>"Danh mục " .$cate['name'],
            "title" =>"Danh mục " .$cate['name'],
            "productList" =>$productList,
            "cates" => $cates,
        ]);
     }
}
