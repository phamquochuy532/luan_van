<?php
    class User extends ControllerBase
    {
        public function login($email, $password)
        {
            $user = $this->model("UserModel");
            $result = $user->checkLogin($email, $password);
            if($result == true) {
                $this->view("index",["thongbao"=> "Dang nhap thanh cong"]);
            }else {
                $this->view("index",["thongbao"=> "Sai tai khoan "]);
            }
        }
    }
    
?>