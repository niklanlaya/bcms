<?php
// ดึงข้อมูล Settings มาใช้ทุกหน้า (Global Settings)
// เราเรียก Model ตรงนี้เพื่อให้ Header มีข้อมูลเสมอ โดยไม่ต้องแก้ Controller ทุกตัว
if (file_exists('../app/models/SettingModel.php')) {
    require_once '../app/models/SettingModel.php';
    $settingModel = new SettingModel();
    $sysConfig = $settingModel->getSettings();
} else {
    // Fallback กรณีหาไฟล์ไม่เจอ (กัน Error)
    $sysConfig = (object) [
        'site_name' => 'BCMS System',
        'school_name' => 'โรงเรียนเตรียมอุดมศึกษา ภาคเหนือ',
        'theme_color' => '#db2777',
        'favicon_path' => '',
        'logo_path' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sysConfig->site_name; ?> - <?php echo $sysConfig->school_name; ?></title>
    
    <!-- Dynamic Favicon -->
    <?php if(!empty($sysConfig->favicon_path)): ?>
    <link rel="icon" type="image/png" href="<?php echo $sysConfig->favicon_path; ?>">
    <?php endif; ?>

    <!-- 1. Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- 2. Google Font Prompt -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- 3. FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    
    <!-- 4. SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- 5. jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Custom Styles -->
    <style>
        :root {
            /* กำหนดตัวแปรสีหลักจากฐานข้อมูล */
            --theme-color: <?php echo $sysConfig->theme_color; ?>;
        }

        body {
            font-family: 'Prompt', sans-serif;
            /* พื้นหลัง Gradient โดยใช้สีจากธีม */
            background: linear-gradient(135deg, #ffffff 0%, #ffe4e6 50%, var(--theme-color) 100%);
            min-height: 100vh;
        }

        /* Override Class ของ Tailwind ให้ใช้สีจากธีม */
        .text-pink-700, .text-pink-600, .text-pink-800 { color: var(--theme-color) !important; }
        .bg-pink-600, .bg-pink-500 { background-color: var(--theme-color) !important; }
        .border-pink-500 { border-color: var(--theme-color) !important; }
        
        /* Hover Effect */
        .hover\:border-pink-500:hover { border-color: var(--theme-color) !important; }
        .hover\:bg-pink-600:hover { background-color: var(--theme-color) !important; filter: brightness(0.9); }

        /* Glassmorphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.75);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .sidebar-glass {
             background: rgba(255, 255, 255, 0.6);
             backdrop-filter: blur(12px);
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_paginate {
            color: var(--theme-color) !important;
            margin-bottom: 1rem;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #fbcfe8;
            border-radius: 0.5rem;
            padding: 0.4rem;
            background: rgba(255,255,255,0.6);
            outline: none;
            color: var(--theme-color);
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            box-shadow: 0 0 0 2px var(--theme-color);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--theme-color) !important;
            color: white !important;
            border: none !important;
            border-radius: 0.3rem;
        }
        
        table.dataTable.no-footer {
            border-bottom: 1px solid #fbcfe8 !important;
        }
    </style>
</head>
<body class="flex text-gray-800">