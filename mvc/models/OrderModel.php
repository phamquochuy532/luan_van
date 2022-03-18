<?php
class orderModel
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new orderModel();
        }

        return self::$instance;
    }

    public function getByuserId($userId)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM orders WHERE userId='$userId'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getById($id)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM orders WHERE id='$id'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function add($userId, $total)
    {
        $db = DB::getInstance();
        $sql = "INSERT INTO `orders` (`id`, `userId`, `createdDate`, `receivedDate`, `status`, `paymentMethod`, `paymentStatus`, `payDate`, `total`) VALUES (NULL, '$userId', DATE_FORMAT('" . Date('d/m/y H:i:s') . "', '%d-%m-%y %H:%i:%s'), NULL, 'processing', 'COD',0,NULL,'$total')";
        $result = mysqli_query($db->con, $sql);

        if ($result) {
            $last_id = $db->con->insert_id;

            foreach ($_SESSION['cart'] as $key => $value) {
                $s = "INSERT INTO `order_details` (`id`, `orderId`, `productId`, `qty`, `productPrice`, `productName`, `productImage`) VALUES (NULL," . $last_id . ", '" . $value['productId'] . "', '" . $value['quantity'] . "', " . $value['price'] . ", '" . $value['productName'] . "', '" . $value['productImage'] . "')";
                $result = mysqli_query($db->con, $s);

                // Update qty
                $sqlUpdateQty = "UPDATE products SET qty = qty - " . $value['quantity'] . " WHERE id = " . $value['productId'] . "";
                $r = mysqli_query($db->con, $sqlUpdateQty);
            }
        } else {
            return false;
        }

        unset($_SESSION['cart']);
        return true;
    }

    public function getAll()
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM orders";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function processed($Id)
    {
        $db = DB::getInstance();
        $sql = "UPDATE orders SET status = 'processed', receivedDate =  DATE_FORMAT('" . Date('d/m/y', strtotime('+3 days')) . "', '%d-%m-%y') WHERE id = $Id";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function delivery($Id)
    {
        $db = DB::getInstance();
        $sql = "UPDATE orders SET status = 'delivery' WHERE id = $Id";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function received($Id)
    {
        $db = DB::getInstance();
        // Cập nhật status thành received
        // receivedDate và payDate thành ngày hiện tại
        $sql = "UPDATE orders SET status = 'received', receivedDate = DATE_FORMAT('" . Date('d/m/y H:i:s') . "', '%d-%m-%y %H:%i:%s'), paymentStatus = 1, payDate =  DATE_FORMAT('" . Date('d/m/y H:i:s') . "', '%d-%m-%y %H:%i:%s') WHERE id = $Id";
        $result = mysqli_query($db->con, $sql);
        if ($result) {
            // Lấy ra danh sách chi tiết đơn hàng để cập nhật số lượng đã bán cho sản phẩm
            $sqlOrderDetail = "SELECT * FROM `order_details` WHERE orderId = $Id";
            $resultOrderDetail = mysqli_query($db->con, $sqlOrderDetail);
            $listOrderDetail = $resultOrderDetail->fetch_all(MYSQLI_ASSOC);

            // Cập nhật số lượng đã bán
            foreach ($listOrderDetail as $key => $value) {
                $sqlUpdateSold = "UPDATE products SET soldCount = soldCount + " . $value['qty'] . " WHERE id = " . $value['productId'] . "";
                $resultUpdateSold = mysqli_query($db->con, $sqlUpdateSold);
            }
        }
        return $resultUpdateSold;
    }

    public function payment($orderId)
    {
        $db = DB::getInstance();
        $sql = "UPDATE orders SET paymentStatus = 1, paymentMethod = 'VNPay', payDate = '" . Date('d/m/y H:i:s') . "' WHERE id = $orderId";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }
}
