<?php
class VehicleModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM vehicles ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM vehicles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data) {
        $sql = "INSERT INTO vehicles (name, plate_number, type, status) VALUES (:name, :plate_number, :type, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE vehicles SET name = :name, plate_number = :plate_number, type = :type, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        // เช็คก่อนว่ารถคันนี้มีการจองค้างอยู่ไหม ถ้ามีไม่ควรลบ (อาจใช้ Soft Delete แต่นี่ทำแบบ Hard Delete ง่ายๆ ไปก่อน)
        $stmt = $this->db->prepare("DELETE FROM vehicles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}