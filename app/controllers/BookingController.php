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

     // [เพิ่มใหม่] หน้าสำหรับพิมพ์ใบขออนุญาต
    public function print($id) {
        if (!isset($_SESSION['user_id'])) { header("Location: /auth/login"); exit; }

        $model = $this->model('BookingModel');
        $booking = $model->getBookingById($id);

        // ป้องกันไม่ให้คนอื่นมาแอบพิมพ์ของคนอื่น (เว้นแต่เป็น Admin/Staff)
        if (!$booking || ($booking->user_id != $_SESSION['user_id'] && $_SESSION['role'] == 'user')) {
             die("ไม่มีสิทธิ์เข้าถึงรายการนี้");
        }
        
        // ดึงข้อมูลชื่อรถเพิ่มเติม (เพราะใน getBookingById อาจไม่มีชื่อรถ)
        // หรือจะแก้ getBookingById ให้ JOIN table vehicles ก็ได้ แต่วิธีนี้ง่ายกว่าสำหรับตอนนี้
        $vehicle_name = '-';
        if ($booking->vehicle_id) {
            $db = (new Database())->connect();
            $stmt = $db->prepare("SELECT name, plate_number FROM vehicles WHERE id = :id");
            $stmt->execute(['id' => $booking->vehicle_id]);
            $vehicle = $stmt->fetch(PDO::FETCH_OBJ);
            if($vehicle) $vehicle_name = $vehicle->name . ' (' . $vehicle->plate_number . ')';
        }
        
        // ดึงชื่อผู้ขอ (User)
        $db = (new Database())->connect();
        $stmt = $db->prepare("SELECT fullname, position, department FROM users WHERE id = :id");
        $stmt->execute(['id' => $booking->user_id]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $this->view('booking/print', [
            'booking' => $booking,
            'vehicle_name' => $vehicle_name,
            'user' => $user
        ]);
    }
}