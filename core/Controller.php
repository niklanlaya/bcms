<?php
class Controller {
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exist.");
        }
    }
    
    // ฟังก์ชันแจ้งเตือน Telegram
    public function sendTelegram($message) {
        
        // ดึงค่าจาก DB โดยตรง
        require_once '../app/models/SettingModel.php';
        $settingModel = new SettingModel();
        $settings = $settingModel->getSettings();

        $token = $settings->telegram_token;
        $chat_id = $settings->telegram_chat_id;
        
        // ถ้าไม่ได้ตั้งค่าไว้ ให้ข้ามไป
        if(empty($token) || empty($chat_id)) return;

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id;
        $url = $url . "&text=" . urlencode($message);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        curl_close($ch);
    }
}