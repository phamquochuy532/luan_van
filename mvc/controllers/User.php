<?php

use LDAP\Result;

    class User extends ControllerBase
    {
        // URL GET
        // FORM POST
        public function login()
        {
          if ($_SERVER['REQUEST_METHOD']=='POST'){
              $email = $_POST['email'];
              $password = $_POST['password'];

              $user = $this->model("UserModel");
              $result = $user->checkLogin($email, $password);
              if ($result) {
                 $u = $result->fetch_assoc();
                 $_SESSION['user_id'] = $u['id'];
                 $this->redirect("Home");
              }else {
                  $this->view("login",[
                      "headTitle"=>"Đăng nhập",
                      "message"=>"Tài khoản hoặc mật khẩu không đúng!"]);
              }
          }else {
              $this->view("login",[
                  "headTitle"=>"Đăng nhập"
              ]);
          }
        }
        public function logout(){
             unset($_SESSION['user_id']);
             $this->redirect("User","login");
        }
        public function register(){
          if($_SERVER['REQUEST_METHOD']=='POST') {
              $fullName = $_POST['fullName'];
              $email = $_POST['email'];
              $dob = $_POST['dob'];
              $address = $_POST['address'];
              $password = $_POST['password'];
              
              $user = $this->model("UserModel");
              $result = $user->insert($fullName, $email, $dob, $address, $password);
              if($result) {
                  $this->view("register",[
                      "headTitle"=>"Đăng ký",
                      "cssClass"=>"success",
                      "message"=>"Đăng ký thành công"
                  ]);
              }else {
                  $this->view("register", [
                      "headTitle"=>"Đăng ký",
                      "cssClass"=>"error",
                      "message"=>"Đăng ký thất bại",
                  ]);
              }
          }else {
              $this->view("register",[
                  "headTitle"=>"Đăng ký"
              ]);
          }
       }
    }
    
?>