<?php

include_once(APP_ROOT . '/libs/PHPMailer.php');
include_once(APP_ROOT . '/libs/Exception.php');
include_once(APP_ROOT . '/libs/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

class UserModel extends DB
{
    public function checkLogin($email, $password)
    {
        $sql = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($this->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows >0) {
            return $result;
        }else {
            return false;
        }
    }
    public function insert($fullName,$email, $dob, $address, $password)
    {
        //generate captcha

        $captcha = rand(100000, 999999);
        $sql = "INSERT INTO Users(`id`, `fullName`, `email`, `dob`, `address`, `password`, `roleId`, `status`, `captcha`, `isConfirmed`) 
        VALUES (NULL,'$fullName','$email','$dob','$address','$password',1,1, '$captcha', 0)";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            // send email
            $mail = new PHPMailer();
            $mail->Mailer = "smtp";

            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;
            $mail->Host       = "smtp.gmail.com";
            $mail->Username   = "huy3180712@gmail.com";
            $mail->Password   = "181201Huy";

            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($email, "recipient-name");
            $mail->SetFrom("huy3180712@gmail.com", "HUYPHAM STORE");
            $mail->Subject = "Xác nhận email tài khoản - HUYPHAM STORE";
            $mail->Body = "<h3>Cảm ơn bạn đã đăng ký tài khoản tại website HUYPHAM STORE</h3></br>Đây là mã xác minh tài khoản của bạn: " . $captcha . "";

            $mail->Send();
            var_dump($mail);
            die();
            return true;
        }else {
            return false;
        }
    }
}
