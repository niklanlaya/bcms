<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบขออนุญาตใช้รถยนต์</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ใช้ฟอนต์ Sarabun สำหรับเอกสารราชการ -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background: #525659; /* สีพื้นหลังตอน Preview */
        }
        .page {
            background: white;
            width: 210mm; /* A4 Width */
            min-height: 297mm; /* A4 Height */
            margin: 20px auto;
            padding: 20mm 20mm; /* ขอบกระดาษ */
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            position: relative;
        }
        @media print {
            body { background: white; margin: 0; }
            .page { 
                width: 100%;
                margin: 0; 
                box-shadow: none; 
                padding: 10mm 15mm;
            }
            .no-print { display: none; }
        }
        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            text-align: center;
            color: #000; /* สีข้อความในจุดไข่ปลา */
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>
<body>

    <!-- ปุ่มสั่งพิมพ์ (จะหายไปตอนปริ้น) -->
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 font-bold">
            🖨️ พิมพ์เอกสาร
        </button>
        <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
            ปิดหน้าต่าง
        </button>
    </div>

    <div class="page text-base leading-relaxed text-black">
        
        <!-- ส่วนหัว -->
        <div class="text-center mb-8">
            <img src="https://upload.wikimedia.org/wikipedia/th/thumb/c/c8/Triam_Udom_Suksa_School_Logo.svg/1200px-Triam_Udom_Suksa_School_Logo.svg.png" alt="Logo" class="h-16 mx-auto mb-2 opacity-80 grayscale">
            <h1 class="text-xl font-bold">แบบขออนุญาตใช้รถยนต์ส่วนกลาง</h1>
            <h2 class="text-lg font-bold">โรงเรียนเตรียมอุดมศึกษา ภาคเหนือ จังหวัดพิษณุโลก</h2>
        </div>

        <!-- วันที่ -->
        <div class="text-right mb-4">
            วันที่ <span class="dotted-line min-w-[50px]"><?php echo date('d', strtotime($data['booking']->created_at)); ?></span> 
            เดือน <span class="dotted-line min-w-[80px]"><?php echo date('m', strtotime($data['booking']->created_at)); ?></span> 
            พ.ศ. <span class="dotted-line min-w-[60px]"><?php echo date('Y', strtotime($data['booking']->created_at)) + 543; ?></span>
        </div>

        <!-- เนื้อหา -->
        <div class="space-y-4">
            <p>
                เรียน ผู้อำนวยการโรงเรียนเตรียมอุดมศึกษา ภาคเหนือ
            </p>
            
            <p class="indent-8">
                ข้าพเจ้า <span class="dotted-line min-w-[200px]"><?php echo $data['user']->fullname; ?></span>
                ตำแหน่ง <span class="dotted-line min-w-[150px]"><?php echo $data['user']->position ?? '-'; ?></span>
            </p>
            
            <p>
                กลุ่มสาระการเรียนรู้/กลุ่มงาน <span class="dotted-line min-w-[200px]"><?php echo $data['user']->department ?? '-'; ?></span>
                มีความประสงค์ขออนุญาตใช้รถยนต์ราชการ
            </p>

            <p>
                เพื่อ (วัตถุประสงค์) <span class="dotted-line w-full block mt-1"><?php echo $data['booking']->purpose; ?></span>
            </p>

            <p>
                สถานที่ <span class="dotted-line min-w-[300px]"><?php echo $data['booking']->destination; ?></span>
                จำนวนคนนั่ง <span class="dotted-line min-w-[50px]"><?php echo $data['booking']->passengers; ?></span> คน
            </p>

            <p>
                ในวันที่ <span class="dotted-line min-w-[50px]"><?php echo date('d', strtotime($data['booking']->start_date)); ?></span>
                เดือน <span class="dotted-line min-w-[80px]"><?php echo date('m', strtotime($data['booking']->start_date)); ?></span>
                พ.ศ. <span class="dotted-line min-w-[60px]"><?php echo date('Y', strtotime($data['booking']->start_date)) + 543; ?></span>
                เวลา <span class="dotted-line min-w-[80px]"><?php echo date('H:i', strtotime($data['booking']->start_date)); ?></span> น.
            </p>

            <p>
                ถึงวันที่ <span class="dotted-line min-w-[50px]"><?php echo date('d', strtotime($data['booking']->end_date)); ?></span>
                เดือน <span class="dotted-line min-w-[80px]"><?php echo date('m', strtotime($data['booking']->end_date)); ?></span>
                พ.ศ. <span class="dotted-line min-w-[60px]"><?php echo date('Y', strtotime($data['booking']->end_date)) + 543; ?></span>
                เวลา <span class="dotted-line min-w-[80px]"><?php echo date('H:i', strtotime($data['booking']->end_date)); ?></span> น.
            </p>

            <p class="indent-8">ในการไปครั้งนี้มีผู้โดยสารจำนวน <span class="dotted-line min-w-[50px]"><?php echo $data['booking']->passengers; ?></span> คน และขอรับรองว่าจะไม่นำไปใช้เพื่อจุดประสงค์อื่นที่นอกเหนือจากที่ระบุไว้</p>
        </div>

        <!-- ลงชื่อผู้ขอ -->
        <div class="mt-12 flex justify-end">
            <div class="text-center w-1/2">
                <p>ลงชื่อ .......................................................... ผู้ขออนุญาต</p>
                <p class="mt-2">( <?php echo $data['user']->fullname; ?> )</p>
            </div>
        </div>

        <hr class="border-black my-8 opacity-50">

        <!-- ส่วนความเห็นเจ้าหน้าที่ยานพาหนะ -->
        <div class="mb-4">
            <h3 class="font-bold underline mb-2">ความเห็นของเจ้าหน้าที่ควบคุมยานพาหนะ</h3>
            <div class="flex gap-4 items-center">
                <div class="w-6 h-6 border border-black flex items-center justify-center text-lg">
                    <?php echo $data['booking']->status == 'director_approved' ? '✓' : ''; ?>
                </div>
                <span>เห็นควรอนุญาต</span>
                
                <span class="ml-4">ให้ใช้รถหมายเลขทะเบียน: <span class="dotted-line min-w-[150px]"><?php echo $data['vehicle_name']; ?></span></span>
            </div>
            <div class="flex gap-4 items-center mt-2">
                <div class="w-6 h-6 border border-black"></div>
                <span>เห็นควรไม่อนุญาต เนื่องจาก ..................................................................................</span>
            </div>
             <div class="mt-4 text-center ml-auto w-1/2">
                <p>ลงชื่อ .......................................................... เจ้าหน้าที่ยานพาหนะ</p>
                <p class="mt-1">( นายสมหมาย ขับรถ )</p> <!-- Hardcode หรือดึงจาก DB ก็ได้ -->
            </div>
        </div>

        <hr class="border-black my-8 opacity-50">

        <!-- ส่วนความเห็นผู้อำนวยการ -->
        <div class="mb-4">
            <h3 class="font-bold underline mb-2">คำสั่งผู้อำนวยการ</h3>
            <div class="flex gap-8">
                <div class="flex gap-2 items-center">
                    <div class="w-6 h-6 border border-black flex items-center justify-center text-lg">
                        <?php echo $data['booking']->status == 'director_approved' ? '✓' : ''; ?>
                    </div>
                    <span>อนุญาต</span>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="w-6 h-6 border border-black flex items-center justify-center text-lg">
                        <?php echo $data['booking']->status == 'rejected' ? '✓' : ''; ?>
                    </div>
                    <span>ไม่อนุญาต</span>
                </div>
            </div>
            
            <div class="mt-8 text-center ml-auto w-1/2">
                <p>ลงชื่อ .......................................................... ผู้อำนวยการ</p>
                <p class="mt-1">( ผอ. มุ่งมั่น )</p>
                <p class="mt-1">........../........../..........</p>
            </div>
        </div>

    </div>
</body>
</html>