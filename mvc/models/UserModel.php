<?php
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
        $sql = "INSERT INTO Users(`id`, `fullName`, `email`, `dob`, `address`, `password`, `roleId`, `isConfirmed`) VALUES (NULL,'$fullName','$email','$dob','$address','$password',1,1)";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }
}
