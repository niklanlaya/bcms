<?php
class BookingController extends Controller {
    
    public function index() {
        // ตรวจสอบ Login
        if (!isset($_SESSION['user_id'])) { header("Location: /auth/login"); exit; }
        
        $model = $this->model('BookingModel');
        $bookings = $model->getAllBookings();
        
        // ดึงข้อมูลรถสำหรับการอนุมัติ (Dropdown)
        $db = (new Database())->connect();
        $stmt = $db->query("SELECT * FROM vehicles");
        $vehicles = $stmt->fetchAll(PDO::FETCH_OBJ);

        $this->view('booking/index', ['bookings' => $bookings, 'vehicles' => $vehicles]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) { header("Location: /auth/login"); exit; }
        $this->view('booking/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'purpose' => $_POST['purpose'],
                'destination' => $_POST['destination'],
                'passengers' => $_POST['passengers'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date']
            ];

            $model = $this->model('BookingModel');
            if ($model->create($data)) {
                // ส่งแจ้งเตือน Telegram
                $msg = "🚗 มีการจองรถใหม่!\nโดย: " . $_SESSION['user_name'] . "\nไปที่: " . $data['destination'] . "\nวันที่: " . $data['start_date'];
                $this->sendTelegram($msg);
                
                // แจ้งเตือนหน้าเว็บ
                $_SESSION['alert'] = ['type' => 'success', 'msg' => 'บันทึกการจองสำเร็จ!'];
                
                header("Location: /booking");
            }
        }
    }
    
    // สำหรับ Staff อนุมัติและเลือกรถ (พร้อมระบบตรวจสอบคิวว่าง)
    public function staffApprove() {
        if ($_SESSION['role'] !== 'staff') return;
        
        $id = $_POST['booking_id'];
        $vehicle_id = $_POST['vehicle_id'];
        $driver_name = $_POST['driver_name'];
        
        $model = $this->model('BookingModel');

        // 1. ดึงข้อมูลการจองปัจจุบันเพื่อเอาวันเวลา
        $currentBooking = $model->getBookingById($id);

        // 2. ตรวจสอบว่ารถว่างหรือไม่ในช่วงเวลานั้น
        $isAvailable = $model->checkVehicleAvailability(
            $vehicle_id, 
            $currentBooking->start_date, 
            $currentBooking->end_date,
            $id
        );

        if (!$isAvailable) {
            // ถ้ารถไม่ว่าง ให้เด้งแจ้งเตือน Error
            $_SESSION['alert'] = [
                'type' => 'error', 
                'msg' => '❌ รถคันนี้ถูกจองไปแล้วในช่วงเวลาดังกล่าว กรุณาเลือกรถคันอื่น'
            ];
            header("Location: /booking");
            return; // จบการทำงานทันที ไม่บันทึก
        }

        // 3. ถ้ารถว่าง ให้บันทึกตามปกติ
        $status = 'staff_approved'; // รอ ผอ. อนุมัติต่อ
        
        $model->updateStatus($id, $status, $vehicle_id, $driver_name);
        
        $_SESSION['alert'] = ['type' => 'success', 'msg' => 'เสนอผู้อำนวยการเรียบร้อยแล้ว'];
        header("Location: /booking");
    }
    
     // สำหรับ Director อนุมัติสุดท้าย
    public function directorApprove() {
        if ($_SESSION['role'] !== 'admin') return;
        
        $id = $_POST['booking_id'];
        $status = $_POST['approval_status'] == 'approve' ? 'director_approved' : 'rejected';
        
        $model = $this->model('BookingModel');
        $model->updateStatus($id, $status);
        
        $_SESSION['alert'] = ['type' => 'success', 'msg' => 'บันทึกการพิจารณาเรียบร้อย'];
        header("Location: /booking");
    }

    // [เพิ่มใหม่] ยกเลิกการจอง
    public function cancel() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['booking_id'];
            
            $model = $this->model('BookingModel');
            $booking = $model->getBookingById($id);

            // Security Check: ต้องเป็นเจ้าของรายการ หรือ เป็น Admin และสถานะต้องเป็น pending
            if ($booking && ($booking->user_id == $_SESSION['user_id'] || $_SESSION['role'] == 'admin')) {
                
                if ($booking->status == 'pending') {
                    $model->delete($id);
                    $_SESSION['alert'] = ['type' => 'success', 'msg' => 'ยกเลิกการจองเรียบร้อยแล้ว'];
                } else {
                    $_SESSION['alert'] = ['type' => 'error', 'msg' => 'ไม่สามารถยกเลิกได้ เนื่องจากรายการถูกดำเนินการแล้ว'];
                }
                
            } else {
                $_SESSION['alert'] = ['type' => 'error', 'msg' => 'คุณไม่มีสิทธิ์ยกเลิกรายการนี้'];
            }

            header("Location: /booking");
        }
    }
}