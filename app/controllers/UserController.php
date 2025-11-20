<?php
class UserController extends Controller {

    // หน้าเปลี่ยนรหัสผ่าน (สำหรับทุกคน)
    public function profile() {
        if (!isset($_SESSION['user_id'])) { header("Location: /auth/login"); exit; }
        $this->view('user/profile');
    }

    // บันทึกการเปลี่ยนรหัสผ่าน
    public function updatePassword() {
        if (!isset($_SESSION['user_id'])) { header("Location: /auth/login"); exit; }
        
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];

        if ($new_pass !== $confirm_pass) {
            $_SESSION['alert'] = ['type' => 'error', 'msg' => 'รหัสผ่านไม่ตรงกัน'];
            header("Location: /user/profile");
            return;
        }

        $model = $this->model('UserModel');
        $model->changePassword($_SESSION['user_id'], $new_pass);
        
        $_SESSION['alert'] = ['type' => 'success', 'msg' => 'เปลี่ยนรหัสผ่านเรียบร้อย'];
        header("Location: /user/profile");
    }

    // --- ส่วนของ Admin (CRUD) ---

    public function index() {
        if ($_SESSION['role'] !== 'admin') { header("Location: /"); exit; }
        
        $model = $this->model('UserModel');
        $users = $model->getAll();
        $this->view('user/index', ['users' => $users]);
    }

    public function create() {
        if ($_SESSION['role'] !== 'admin') { header("Location: /"); exit; }
        $this->view('user/form');
    }

    public function store() {
        if ($_SESSION['role'] !== 'admin') return;

        $model = $this->model('UserModel');
        // รับค่าจากฟอร์ม
        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'], // รหัสสด (Model จะไป Hash เอง)
            'fullname' => $_POST['fullname'],
            'position' => $_POST['position'],
            'department' => $_POST['department'],
            'role' => $_POST['role']
        ];

        if ($model->create($data)) {
            $_SESSION['alert'] = ['type' => 'success', 'msg' => 'เพิ่มผู้ใช้งานเรียบร้อย'];
            header("Location: /user");
        }
    }

    public function edit($id) {
        if ($_SESSION['role'] !== 'admin') return;
        $model = $this->model('UserModel');
        $user = $model->getById($id);
        $this->view('user/form', ['user' => $user]);
    }

    public function update($id) {
        if ($_SESSION['role'] !== 'admin') return;
        $model = $this->model('UserModel');
        
        $data = [
            'id' => $id,
            'username' => $_POST['username'],
            'fullname' => $_POST['fullname'],
            'position' => $_POST['position'],
            'department' => $_POST['department'],
            'role' => $_POST['role']
        ];
        
        // ถ้ากรอกรหัสใหม่มาด้วย ให้ใส่เข้าไปใน array
        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        if ($model->update($data)) {
            $_SESSION['alert'] = ['type' => 'success', 'msg' => 'แก้ไขข้อมูลเรียบร้อย'];
            header("Location: /user");
        }
    }

    public function delete($id) {
        if ($_SESSION['role'] !== 'admin') return;
        // ห้ามลบตัวเอง
        if ($id == $_SESSION['user_id']) {
            $_SESSION['alert'] = ['type' => 'error', 'msg' => 'ไม่สามารถลบบัญชีตัวเองได้'];
            header("Location: /user");
            return;
        }

        $model = $this->model('UserModel');
        $model->delete($id);
        $_SESSION['alert'] = ['type' => 'success', 'msg' => 'ลบผู้ใช้งานเรียบร้อย'];
        header("Location: /user");
    }
}