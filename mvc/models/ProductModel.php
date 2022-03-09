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

    public function search($keyword)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM Products WHERE MATCH(name,description) AGAINST ('$keyword') AND status=1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }


}