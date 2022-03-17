<?php

class Order extends ControllerBase
{
    public function add($total)
    {
        $order = $this->model("orderModel");
        $result = $order->add($_SESSION['user_id'], $total);

        if ($result) {
            $this->view("client/message", [
                "headTitle" => "Thông báo",
                "message" => "Đặt hàng thành công!"
            ]);
        } else {
            $this->view("client/message", [
                "headTitle" => "Thông báo",
                "message" => "Đặt hàng thất bại!"
            ]);
        }
    }

    public function checkout() {
        $order = $this->model('OrderModel');
        $result = $order->getByUserId($_SESSION['user_id']);
        //fetch
        $orderList = $result->fetch_all(MYSQLI_ASSOC);
        $this->view('/client/order',[
            "headTitle"=>"Đơn đặt hàng của tôi",
            "orderList"=>$orderList
        ]);
    }

    public function detail($orderId)
    {
        $orderDetail = $this->model("orderDetailModel");
        $result = $orderDetail->getByorderId($orderId);
        // Fetch
        $orderDetailList = $result->fetch_all(MYSQLI_ASSOC);

        $this->view("client/orderDetail", [
            "headTitle" => "Chi tiết đơn hàng: " . $orderId,
            "orderId" => $orderId,
            "orderDetailList" => $orderDetailList
        ]);
    }
}