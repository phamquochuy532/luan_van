<?php

include_once(APP_ROOT . '/libs/PHPMailer.php');
include_once(APP_ROOT . '/libs/Exception.php');
include_once(APP_ROOT . '/libs/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

class ProductModel
{
    private static $instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new ProductModel();
        }

        return self::$instance;
    }

    public function getById($Id)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM Products WHERE Id='$Id' AND status=1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getByCateId($CateId)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM Products WHERE categoryId='$CateId' AND status=1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getFeaturedProducts()
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM Products WHERE status=1 ORDER BY soldCount DESC";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function search($keyword)
    {
        $db = DB ::getInstance();
        $sql = "SELECT * FROM Products WHERE match(name, description) AGAINST ('$keyword') AND status = 1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function checkQuantity($Id, $qty) {
        $db = DB ::getInstance();
        $sql = "SELECT quantity FROM Products WHERE  status = 1 AND Id ='$Id' ";
        $result = mysqli_query($db->con, $sql);
        $product = $result->fetch_assoc();
        if (intval($qty) > intval($product['quantity'])) {
            return false;
        }
        return true;
    }
}