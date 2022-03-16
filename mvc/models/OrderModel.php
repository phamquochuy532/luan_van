<?php

class OrderModel
{
    private static $instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new OrderModel();
        }

        return self::$instance;
    }

    public function getByUserId($userId) {
        $db = DB::getInstance();
        $sql = "SELECT * FROM orders WHERE userId = '$userId'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function add($userId, $paymentMethod) {
        $db = DB::getInstance();
        $sqlOrder = "INSERT INTO `orders` (`id`, `userId`, `createdDate`, `receivedDate`, `status`, `payStatus`, `paymentMethod`) VALUES (NULL, '$userId', '".date('d/m/y')."', NULL, 'processing', '0', '$paymentMethod')";
        $resultOrder = mysqli_query($db->con, $sqlOrder);
        if ($resultOrder) {
            $last_id = $db->con->insert_id;

            foreach ($_SESSION['cart'] as $key =>$value) {
                $sqlOrderDetail = "INSERT INTO `orderdetails` (`id`, `orderId`, `productId`, `quantity`, `productPrice`, `productName`, `productImage`) VALUES (NULL," . $last_id . ", " . $value['productId'] . ", " . $value['quantity'] . ", " . $value['price'] . ", '" . $value['productName'] . "', '" . $value['productImage'] . "')";
                $resultOrderDetail = mysqli_query($db->con, $sqlOrderDetail);
                if ($resultOrderDetail) {
                    // update quantity
                    $sqlUpdateQuantity = "UPDATE products SET quantity = quantity - ".$value['quantity']." WHERE id = ".$value['productId']."";
                    // echo $sqlUpdateQuantity;die();
                    $resultUpdateQuantity = mysqli_query($db->con, $sqlUpdateQuantity);
                    if (!$resultUpdateQuantity) {
                        return false;
                    }
                }else {
                    return false;
                }
            }
        }else {
            return false;
        }

        unset($_SESSION['cart']);
        return true;
    }
}