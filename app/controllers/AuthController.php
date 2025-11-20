<?php
class AuthController extends Controller {
    public function login() {
        $this->view('auth/login');
    }

    public function authenticate() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = (new Database())->connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        // ในระบบจริงควรใช้ password_verify($password, $user->password)
        // แต่สำหรับตัวอย่างนี้ เราข้ามการ hash เพื่อความง่าย หรือใช้รหัสผ่าน 'password' ตาม mock data
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->fullname;
            $_SESSION['role'] = $user->role;
            header("Location: /booking");
        } else {
            header("Location: /auth/login?error=true");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /");
    }
}