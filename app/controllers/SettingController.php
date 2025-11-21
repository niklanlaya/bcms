<?php
class SettingController extends Controller {

    public function __construct() {
        // เฉพาะ Admin เท่านั้น
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: /");
            exit;
        }
    }

    public function index() {
        $model = $this->model('SettingModel');
        $settings = $model->getSettings();
        $this->view('admin/setting', ['settings' => $settings]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'site_name' => $_POST['site_name'],
                'school_name' => $_POST['school_name'],
                'footer_text' => $_POST['footer_text'],
                'theme_color' => $_POST['theme_color'],
                'telegram_token' => $_POST['telegram_token'],
                'telegram_chat_id' => $_POST['telegram_chat_id']
            ];

            // จัดการ File Upload (Logo)
            if (!empty($_FILES['logo']['name'])) {
                $targetDir = "../public/uploads/";
                if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
                
                $fileName = time() . "_logo_" . basename($_FILES["logo"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFilePath)) {
                    $data['logo_path'] = "/uploads/" . $fileName;
                }
            }

            // จัดการ File Upload (Favicon)
            if (!empty($_FILES['favicon']['name'])) {
                $targetDir = "../public/uploads/";
                $fileName = time() . "_fav_" . basename($_FILES["favicon"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES["favicon"]["tmp_name"], $targetFilePath)) {
                    $data['favicon_path'] = "/uploads/" . $fileName;
                }
            }

            $model = $this->model('SettingModel');
            if ($model->update($data)) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => 'บันทึกการตั้งค่าเรียบร้อย'];
            } else {
                $_SESSION['alert'] = ['type' => 'error', 'msg' => 'เกิดข้อผิดพลาดในการบันทึก'];
            }
            header("Location: /setting");
        }
    }
}