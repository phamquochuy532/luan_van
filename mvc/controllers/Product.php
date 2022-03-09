<?php

class Product extends ControllerBase
{
    public function search($keyword)
    {
        $product = $this->model("ProductModel");
        $result = $product->search($keyword);
        // Fetch
        $productList = $result->fetch_all(MYSQLI_ASSOC);
        $this->view("products", [
            "headTitle" => "Tìm kiếm",
            "title" => "Tìm kiếm với từ khóa: " . $keyword,
            "productList" => $productList
        ]);
    }
}
