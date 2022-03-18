<?php

class OrderManage extends ControllerBase
{
    public function Index()
    {
        // Phân quyền
        // Khởi tạo model
        $user = $this->model("userModel");
        // Gọi hàm lấy quyền
        $result = $user->getRole(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "0");
        if ($result) {
            // Fetch
            $r = $result->fetch_assoc();
            // Nếu roleId khác 1 thì chuyển đến trang chủ
            if ($r['roleId'] != "1") {
                $this->redirect("home");
            }
        } else {
            $this->redirect("home");
        }

        // Khởi tạo model
        $order = $this->model("orderModel");
        // Gọi hàm lấy ra đơn hàng
        $result = $order->getAll();
        // Fetch
        $orderList = $result->fetch_all(MYSQLI_ASSOC);

        $this->view("admin/order", [
            "headTitle" => "Quản lý đơn đặt hàng",
            "orderList" => $orderList
        ]);
    }

    public function detail($orderId)
    {
        // Khởi tạo model
        $orderDetail = $this->model("orderDetailModel");
        // Lấy ra chi tiết đơn hàng theo user
        $result = $orderDetail->getByorderId($orderId);
        // Fetch
        $orderDetailList = $result->fetch_all(MYSQLI_ASSOC);

        // Khởi tạo model
        $order = $this->model("orderModel");
        // Lấy ra đơn hàng theo user
        $result = $order->getById($orderId);

        $this->view("admin/orderDetail", [
            "headTitle" => "Chi tiết đơn hàng: " . $orderId,
            "orderId" => $orderId,
            "orderDetailList" => $orderDetailList,
            "order" => $result->fetch_assoc()
        ]);
    }

    public function processed($orderId)
    {
        // Khởi tạo model
        $order = $this->model("orderModel");
        // Gọi hàm processed để xác nhận đơn hàng
        $result = $order->processed($orderId);
        if ($result) {
            $this->redirect("orderManage", "detail", [
                "orderId" => $orderId
            ]);
        }
    }

    public function delivery($orderId)
    {
        // Khởi tạo model
        $order = $this->model("orderModel");
        // Gọi hàm delivery để update status cho order
        $result = $order->delivery($orderId);
        if ($result) {
            $this->redirect("orderManage");
        }
    }
}
