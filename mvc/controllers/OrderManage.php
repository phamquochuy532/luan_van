<?php

class OrderManage extends ControllerBase
{
    public function Index()
    {
        $order = $this->model("orderModel");
        $result = $order->getAll();
        $orderList = $result->fetch_all(MYSQLI_ASSOC);

        $this->view("admin/order", [
            "headTitle" => "Quản lý đơn đặt hàng",
            "orderList" => $orderList
        ]);
    }
}