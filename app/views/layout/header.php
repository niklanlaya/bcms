<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจองรถยนต์ - เตรียมอุดมศึกษา ภาคเหนือ</title>
    
    <!-- 1. Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- 2. Google Font Prompt -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- 3. FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    
    <!-- 4. SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- 5. jQuery & DataTables (Search, Sort, Pagination) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Custom Styles -->
    <style>
        /* ตั้งค่าฟอนต์หลัก */
        body {
            font-family: 'Prompt', sans-serif;
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 50%, #f472b6 100%); /* Pink Gradients */
            min-height: 100vh;
        }

        /* ธีมกระจก (Glassmorphism) */
        .glass {
            background: rgba(255, 255, 255, 0.7); /* ปรับความทึบให้ตัวหนังสืออ่านง่ายขึ้น */
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .sidebar-glass {
             background: rgba(255, 255, 255, 0.4);
             backdrop-filter: blur(12px);
        }

        /* ปรับแต่ง DataTables ให้เข้ากับธีมสีชมพู */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_paginate {
            color: #831843 !important; /* text-pink-900 */
            margin-bottom: 1rem;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        
        /* ช่องค้นหาในตาราง */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #fbcfe8; /* pink-200 */
            border-radius: 0.5rem;
            padding: 0.4rem;
            background: rgba(255,255,255,0.6);
            outline: none;
            color: #831843;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            box-shadow: 0 0 0 2px #f472b6; /* ring-pink-400 */
        }

        /* เลือกจำนวนแถว */
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #fbcfe8;
            border-radius: 0.3rem;
            padding: 0.2rem;
            background: rgba(255,255,255,0.6);
            outline: none;
        }

        /* ปุ่มเปลี่ยนหน้า Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #f472b6 !important; /* Pink-400 */
            color: white !important;
            border: none !important;
            border-radius: 0.3rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #fbcfe8 !important; /* Pink-200 */
            color: #831843 !important;
            border: 1px solid #fbcfe8 !important;
        }

        /* เส้นขอบตาราง */
        table.dataTable.no-footer {
            border-bottom: 1px solid #fbcfe8 !important;
        }
    </style>
</head>
<body class="flex text-gray-800">