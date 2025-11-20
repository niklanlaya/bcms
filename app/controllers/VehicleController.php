<?php
class VehicleController extends Controller {
    
    public function __construct() {
        // ตรวจสอบสิทธิ์: ต้อง Login และต้องไม่ใช่ User ธรรมดา
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'user') {
            header("Location: /");
            exit;
        }
    }

    public function index() {
        $model = $this->model('VehicleModel');
        $vehicles = $model->getAll();
        $this->view('vehicle/index', ['vehicles' => $vehicles]);
    }

    public function create() {
        $this->view('vehicle/form'); // ใช้ฟอร์มเดียวกับ Edit
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'plate_number' => $_POST['plate_number'],
                'type' => $_POST['type'],
                'status' => $_POST['status']
            ];
            
            $model = $this->model('VehicleModel');
            if ($model->create($data)) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => 'เพิ่มข้อมูลรถเรียบร้อย'];
                header("Location: /vehicle");
            }
        }
    }

    public function edit($id) {
        $model = $this->model('VehicleModel');
        $vehicle = $model->getById($id);
        $this->view('vehicle/form', ['vehicle' => $vehicle]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'plate_number' => $_POST['plate_number'],
                'type' => $_POST['type'],
                'status' => $_POST['status']
            ];
            
            $model = $this->model('VehicleModel');
            if ($model->update($data)) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => 'แก้ไขข้อมูลเรียบร้อย'];
                header("Location: /vehicle");
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('VehicleModel');
            if ($model->delete($id)) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => 'ลบข้อมูลเรียบร้อย'];
            } else {
                $_SESSION['alert'] = ['type' => 'error', 'msg' => 'ไม่สามารถลบได้ (อาจมีรายการจองค้างอยู่)'];
            }
            header("Location: /vehicle");
        }
    }
}