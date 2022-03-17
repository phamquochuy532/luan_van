<?php

use LDAP\Result;

class User extends ControllerBase
{
    // URL GET
    // FORM POST
    public function login()
    {
        // Kiểm tra REQUEST_METHOD là GET hay POST
        // Nếu là POST thì thực hiện đăng nhập
        // Nếu là GET thì hiển thị trang login
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tạo 2 biến để lưu giá trị nhập từ form
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Khởi tạo model để gọi các hàm
            $user = $this->model("UserModel");
            // Gọi hàm checkLogin (có 2 tham số là email và password)
            $result = $user->checkLogin($email, $password);
            // Kiểm tra kết quả
            if ($result) {
                // Đọc dữ liệu user ra
                $u = $result->fetch_assoc();
                // Lưu vào session
                $_SESSION['user_id'] = $u['id'];
                // Chuyển đến trang Home
                $this->redirect("Home");
            } else {
                // Hiển thị sai
                $this->view("/client/login", [
                    "headTitle" => "Đăng nhập",
                    "message" => "Tài khoản hoặc mật khẩu không đúng!"
                ]);
            }
        } else {
            // Hiển thị trang view
            $this->view("/client/login", [
                "headTitle" => "Đăng nhập"
            ]);
        }
    }
    public function logout()
    {
        // Unset session
        unset($_SESSION['user_id']);
        // Chuyển đến trang đăng nhập
        $this->redirect("User", "login");
    }
    public function register()
    {
        // Kiểm tra REQUEST_METHOD là GET hay POST
        // Nếu là POST thì thực hiện đăng ký
        // Nếu là GET thì hiển thị trang register
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tạo các biến lưu các giá trị từ form
            $fullName = $_POST['fullName'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];

            // Khởi tạo model để gọi các hàm
            $user = $this->model("UserModel");
            // Gọi hàm checkEmail (tham số email) để kiểm tra email có tồn tại trong csdl hay ko?
            $checkEmail = $user->checkEmail($email);
            if (!$checkEmail) {
                // Gọi hàm checkPhone (tham số phone) để kiểm tra phone có tồn tại trong csdl hay ko?
                $checkPhone = $user->checkPhone($phone);
                if (!$checkPhone) {
                    // Hiển thị email và phone đã tồn tại
                    $this->view("/client/register", [
                        "headTitle" => "Đăng ký",
                        "messageEmail" => "Email đã tồn tại ",
                        "messagePhone" => "Số điện thoại đã tồn tại",
                    ]);
                } else {
                    // Hiển thị email đã tồn tại
                    $this->view("/client/register", [
                        "headTitle" => "Đăng ký",
                        "messageEmail" => "Email đã tồn tại ",
                    ]);
                }
                return;
            } else {
                // Gọi hàm checkPhone (tham số phone) để kiểm tra phone có tồn tại trong csdl hay ko?
                $checkPhone = $user->checkPhone($phone);
                if (!$checkPhone) {
                    // Hiển thị phone đã tồn tại
                    $this->view("/client/register", [
                        "headTitle" => "Đăng ký",
                        "messagePhone" => "Số điện thoại đã tồn tại",
                    ]);
                }
                return;
            }

            // Gọi hàm insert để thêm user vào csdl
            $result = $user->insert($fullName, $email, $dob, $address, $password);
            if ($result) {
                // Chuyển đến trang xác minh
                $this->redirect("User", "confirm", [
                    "email" => $email
                ]);
            } else {
                // Hiển thị lỗi
                $this->view("/client/register", [
                    "headTitle" => "Đăng ký",
                    "cssClass" => "error",
                    "message" => "Đăng ký thất bại",
                ]);
            }
        } else {
            // Hiển thị trang register
            $this->view("/client/register", [
                "headTitle" => "Đăng ký"
            ]);
        }
    }
    public function confirm($email)
    {
        // Kiểm tra REQUEST_METHOD là GET hay POST
        // Nếu là POST thì thực hiện đăng ký
        // Nếu là GET thì hiển thị trang register
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tạo biến lưu giá trị từ form
            $captcha = $_POST['captcha'];

            // Khởi tạo model để gọi các hàm
            $user = $this->model("UserModel");
            // Gọi hàm confirm (tham số email và captcha)
            $result = $user->confirm($email, $captcha);

            if ($result) {
                // Hiển thị thành công
                $this->view("/client/confirm", [
                    "headTitle" => "Xác minh tài khoản",
                    "email" => $email,
                    "cssClass" => "success",
                    "message" => "Xác minh tài khoản thành công"
                ]);
            } else {
                // Hiển thị mã xác minh không đúng
                $this->view("/client/confirm", [
                    "headTitle" => "Xác minh tài khoản",
                    "email" => $email,
                    "cssClass" => "error",
                    "message" => "Mã xác minh không đúng"
                ]);
            }
        } else {
            // Hiển thị trang xác minh
            $this->view("/client/confirm", [
                "headTitle" => "Xác minh tài khoản",
                "email" => $email
            ]);
        }
    }
}
