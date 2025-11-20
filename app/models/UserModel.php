<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // ดึง User ทั้งหมด (สำหรับ Admin)
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY role DESC, id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ดึงข้อมูล User ตาม ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // สร้าง User ใหม่
    public function create($data) {
        $sql = "INSERT INTO users (username, password, fullname, position, department, role) 
                VALUES (:username, :password, :fullname, :position, :department, :role)";
        $stmt = $this->db->prepare($sql);
        // Hash Password ก่อนบันทึก
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $stmt->execute($data);
    }

    // อัปเดตข้อมูล User (Admin แก้ไข)
    public function update($data) {
        // ถ้ามีการส่ง password มาใหม่ ให้ update ด้วย (พร้อม Hash)
        if (!empty($data['password'])) {
            $sql = "UPDATE users SET username=:username, password=:password, fullname=:fullname, position=:position, department=:department, role=:role WHERE id=:id";
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // ถ้าไม่แก้รหัสผ่าน ตัด key password ออก
            $sql = "UPDATE users SET username=:username, fullname=:fullname, position=:position, department=:department, role=:role WHERE id=:id";
            unset($data['password']);
        }
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // เปลี่ยนรหัสผ่าน (สำหรับ User แก้ตัวเอง)
    public function changePassword($id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id, 'password' => $hash]);
    }

    // ลบ User
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}