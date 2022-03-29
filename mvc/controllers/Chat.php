<?php

class chat extends ControllerBase
{
    public function send($content)
    {
        // Set header để gửi JSON về cho client
        header('Content-Type: application/json; charset=utf-8');
        // khởi tạo model
        $message = $this->model("messageModel");
        // Thêm tin nhắn vào csdl
        if ($message->insert($_SESSION['user_id'], 59, $content)) {
            // Khởi tạo model
            $bot = $this->model("botModel");
            // Lấy ra tin nhắn bot
            $result = $bot->getReplies($content);
            // Set status code 200
            http_response_code(200);
            if ($result) {
                // Insert DB
                $message->insert(59, $_SESSION['user_id'], $result['replies']);
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            } 
            // else {
            //     // $message->insert(59, $_SESSION['user_id'], 'Cảm ơn bạn đã nhắn tin, chúng tôi sẽ phản hồi sớm nhất có thể!');
            //     echo json_encode([
            //         "replies" => "Cảm ơn bạn đã nhắn tin, chúng tôi sẽ phản hồi sớm nhất có thể!"
            //     ], JSON_UNESCAPED_UNICODE);
            // }
        } else {
            // Set status code 500
            http_response_code(500);
        }
    }

    public function sendAdmin($content)
    {
        // Set header để gửi JSON về cho client
        header('Content-Type: application/json; charset=utf-8');
        // Khởi tạo model
        $message = $this->model("messageModel");
        // Thêm tin nhắn vào csdl
        $result = $message->insert($_SESSION['user_id'], 59, $content);
        if ($result) {
            // Set status code 200
            http_response_code(200);
        } else {
            // Set status code 500
            http_response_code(500);
        }
    }

    public function getData()
    {
        // header('Content-Type: application/json; charset=utf-8');
        // Khởi tạo model
        $message = $this->model("messageModel");
        // Lấy dữ liệu tin nhắn cũ
        $result = ($message->getData($_SESSION['user_id'], 59))->fetch_all(MYSQLI_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function chatList()
    {
        $message = $this->model("messageModel");
        $result = ($message->getUserChating($_SESSION['user_id'], 59))->fetch_all(MYSQLI_ASSOC);
        $this->view("admin/chatList", [
            "headTitle" => "Chat với khách hàng",
            "userList" => $result
        ]);
    }

    public function chating($userId)
    {
        header('Content-Type: application/json; charset=utf-8');
        $message = $this->model("messageModel");
        $result = ($message->getDataChating($_SESSION['user_id'], $userId))->fetch_all(MYSQLI_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
