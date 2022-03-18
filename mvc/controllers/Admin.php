<?php
class Admin extends ControllerBase{
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
        }else {
            $this->redirect("home");
        }

        // Khởi tạo model
        $order = $this->model("orderModel");
        // Gọi hàm lấy ra danh sách đơn hàng mới
        $result = $order->getByuserId($_SESSION['user_id']);
        // Fetch
        $orderList = $result->fetch_all(MYSQLI_ASSOC);

        $this->view("admin/index", [
            "headTitle" => "Trang quản trị",
            "orderList" => $orderList
        ]);
    }
}
