<?php
class BookingModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // ดึงข้อมูลการจองทั้งหมด (สำหรับ Admin/Staff)
    public function getAllBookings() {
        $sql = "SELECT b.*, u.fullname as requester_name, v.name as vehicle_name 
                FROM bookings b 
                LEFT JOIN users u ON b.user_id = u.id 
                LEFT JOIN vehicles v ON b.vehicle_id = v.id 
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // ดึงข้อมูลการจองที่อนุมัติแล้ว (สำหรับปฏิทิน)
    public function getApprovedBookings() {
        $sql = "SELECT b.*, u.fullname, v.name as vehicle_name 
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                LEFT JOIN vehicles v ON b.vehicle_id = v.id
                WHERE b.status = 'director_approved'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // สร้างใบจองใหม่
    public function create($data) {
        $sql = "INSERT INTO bookings (user_id, purpose, destination, passengers, start_date, end_date) 
                VALUES (:user_id, :purpose, :destination, :passengers, :start_date, :end_date)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // [ฟังก์ชันใหม่ 1] ดึงข้อมูลการจอง 1 รายการ
    public function getBookingById($id) {
        $sql = "SELECT * FROM bookings WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // [ฟังก์ชันใหม่ 2] เช็คว่ารถว่างหรือไม่ (Logic: รถคันนี้ + สถานะอนุมัติแล้ว + เวลาทับซ้อนกัน)
    public function checkVehicleAvailability($vehicle_id, $start_date, $end_date, $current_booking_id) {
        $sql = "SELECT COUNT(*) as count FROM bookings 
                WHERE vehicle_id = :vehicle_id 
                AND id != :current_id 
                AND status IN ('staff_approved', 'director_approved') 
                AND (
                    (start_date < :end_date AND end_date > :start_date)
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'vehicle_id' => $vehicle_id,
            'current_id' => $current_booking_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count == 0; // 0 = ว่าง (True), >0 = ไม่ว่าง (False)
    }

    // อัปเดตสถานะ (Staff / Director)
    public function updateStatus($id, $status, $vehicle_id = null, $driver_name = null) {
        if ($vehicle_id) {
            // กรณี Staff เป็นคนทำรายการ (ระบุรถ/คนขับ)
            $sql = "UPDATE bookings SET status = :status, vehicle_id = :vehicle_id, driver_name = :driver_name, staff_approved_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id'=>$id, 'status'=>$status, 'vehicle_id'=>$vehicle_id, 'driver_name'=>$driver_name]);
        } else {
            // กรณี Director เป็นคนทำรายการ (อนุมัติ/ไม่อนุมัติ)
            $sql = "UPDATE bookings SET status = :status, director_approved_at = NOW() WHERE id = :id";
             $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id'=>$id, 'status'=>$status]);
        }
    }

    // [เพิ่มใหม่] ลบการจอง
    public function delete($id) {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // [เพิ่มใหม่] ดึงจำนวนการจองแยกตามสถานะ
    public function getStatsByStatus() {
        $sql = "SELECT status, COUNT(*) as count FROM bookings GROUP BY status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // [เพิ่มใหม่] ดึงจำนวนการใช้งานรถแต่ละคัน
    public function getVehicleUsageStats() {
        $sql = "SELECT v.name, COUNT(b.id) as count 
                FROM vehicles v 
                LEFT JOIN bookings b ON v.id = b.vehicle_id AND b.status = 'director_approved'
                GROUP BY v.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}