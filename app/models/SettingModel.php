<?php
class SettingModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // ดึงค่าการตั้งค่าทั้งหมด (แถวเดียว)
    public function getSettings() {
        $stmt = $this->db->prepare("SELECT * FROM settings WHERE id = 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // อัปเดตการตั้งค่า
    public function update($data) {
        $sql = "UPDATE settings SET 
                site_name = :site_name,
                school_name = :school_name,
                footer_text = :footer_text,
                theme_color = :theme_color,
                telegram_token = :telegram_token,
                telegram_chat_id = :telegram_chat_id";
        
        // ถ้ามีการอัปโหลดโลโก้ใหม่
        if (!empty($data['logo_path'])) {
            $sql .= ", logo_path = :logo_path";
        }
        // ถ้ามีการอัปโหลด Favicon ใหม่
        if (!empty($data['favicon_path'])) {
            $sql .= ", favicon_path = :favicon_path";
        }

        $sql .= " WHERE id = 1";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}