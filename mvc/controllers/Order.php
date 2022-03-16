<?php

class Order extends ControllerBase
{
    public function add() {
        $order = $this->model('OrderModel');
        $result = $order->add($_SESSION['user_id'],$_POST['payment']);
        if ($result) {
            $this->view('message',[
                "headTitle"=>"Thông báo",
                "message"=>"Đặt hàng thành công"
            ]);
        }else {
            $this->view('message',[
                "headTitle"=>"Thông báo",
                "message"=>"Đặt hàng thất bại"
            ]);
        }
    }

    public function checkout() {
        $order = $this->model('OrderModel');
        $result = $order->getByUserId($_SESSION['user_id']);
        //fetch
        $orderList = $result->fetch_all(MYSQLI_ASSOC);
        $this->view('order',[
            "headTitle"=>"Đơn đặt hàng của tôi",
            "orderList"=>$orderList
        ]);
    }
}