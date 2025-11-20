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
        // นำ Token และ Chat ID มาใส่ตรงนี้
        $token = "8579581106:AAFFMVnj3PmnQgHnDBJGdgI-ziFTNY06xBI";     // <-- อย่าลืมใส่ Token จริง
        $chat_id = "8395704207"; // <-- อย่าลืมใส่ Chat ID จริง
        
        if($token == "YOUR_TELEGRAM_BOT_TOKEN") return; 

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id;
        $url = $url . "&text=" . urlencode($message);
        
        // ยิง Request
        $ch = curl_init();
        
        // *** แก้ไขบรรทัดนี้ครับ (ลบ _OPT ออก) ***
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        curl_close($ch);
    }
}