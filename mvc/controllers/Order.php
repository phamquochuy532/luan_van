<?php

class Order extends ControllerBase
{
    public function add($total)
    {
        // Khởi tạo model
        $order = $this->model("orderModel");
        // Gọi hàm add để thêm mới đơn hàng và chi tiết đơn hàng
        $result = $order->add($_SESSION['user_id'], $total);
        // Nếu thành công thì chuyển đến trang thông báo
        if ($result) {
            $this->redirect("Order","message",[
                "message"=>"Đặt hàng thành công!"
            ]);
        } else {
            $this->redirect("Order","message",[
                "message"=>"Đặt hàng thất bại!"
            ]);
        }
    }

    public function checkout() {
        // Khởi tạo model
        $order = $this->model('OrderModel');
        // Gọi hàm lấy theo userId
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
        // Khởi tạo model
        $orderDetail = $this->model("orderDetailModel");
        // Gọi hàm lấy theo orderId
        $result = $orderDetail->getByorderId($orderId);
        // Fetch
        $orderDetailList = $result->fetch_all(MYSQLI_ASSOC);

        $this->view("client/orderDetail", [
            "headTitle" => "Chi tiết đơn hàng: " . $orderId,
            "orderId" => $orderId,
            "orderDetailList" => $orderDetailList
        ]);
    }

    public function message($message){
        $this->view('/client/message',[
            "headTitle"=>"Thông báo",
            "message"=>$message
        ]);
    }

    public function received($orderId)
    {
        // Khởi tạo model
        $order = $this->model("orderModel");
        // Gọi hàm recived để cập nhật đơn hàng
        $result = $order->received($orderId);
        if ($result) {
            $this->redirect("order","checkout");
        }
    }
}