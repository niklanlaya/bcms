<?php
class AuthController extends Controller {
    
    public function login() {
        // ถ้า Login อยู่แล้วให้เด้งไปหน้าจองเลย
        if (isset($_SESSION['user_id'])) {
            header("Location: /booking");
            exit;
        }
        $this->view('auth/login');
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $db = (new Database())->connect();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            // ตรวจสอบรหัสผ่าน (รองรับทั้ง User เก่าและใหม่ที่ผ่านการ Hash)
            if ($user && password_verify($password, $user->password)) {
                // Login สำเร็จ
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->fullname;
                $_SESSION['role'] = $user->role;
                
                // แจ้งเตือนต้อนรับ
                $_SESSION['alert'] = ['type' => 'success', 'msg' => 'ยินดีต้อนรับ ' . $user->fullname];
                
                header("Location: /booking");
            } else {
                // Login ไม่สำเร็จ
                header("Location: /auth/login?error=true");
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /");
    }
}