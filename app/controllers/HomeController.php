<?php
class HomeController extends Controller {
    public function index() {
        $bookingModel = $this->model('BookingModel');
        $bookings = $bookingModel->getApprovedBookings();
        
        // แปลงข้อมูลเพื่อใช้กับ FullCalendar
        $events = [];
        foreach($bookings as $b) {
            $events[] = [
                'title' => $b->destination . ' (' . $b->vehicle_name . ')',
                'start' => $b->start_date,
                'end' => $b->end_date,
                'color' => '#db2777' // Pink 600
            ];
        }

        $data = ['events' => json_encode($events)];
        $this->view('home/index', $data);
    }

    // [เพิ่มใหม่] หน้า Dashboard
    public function dashboard() {
        if (!isset($_SESSION['user_id'])) { header("Location: /auth/login"); exit; }

        $model = $this->model('BookingModel');
        
        // เตรียมข้อมูล
        $statusData = $model->getStatsByStatus();
        $vehicleData = $model->getVehicleUsageStats();
        
        $this->view('home/dashboard', [
            'statusData' => $statusData,
            'vehicleData' => $vehicleData
        ]);
    }
}