<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="w-full">
    <h2 class="text-2xl font-bold text-pink-700 mb-6">📝 รายการจองยานพาหนะ</h2>

    <div class="glass p-6 overflow-hidden">
        <!-- เพิ่ม ID="bookingTable" และ Class สำหรับ DataTables -->
        <table id="bookingTable" class="min-w-full text-sm text-left display responsive nowrap" style="width:100%">
            <thead class="bg-pink-500/20 text-pink-900 uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">วันที่ใช้รถ</th>
                    <th class="px-6 py-4">ผู้ขอ / สถานที่</th>
                    <th class="px-6 py-4">สถานะ</th>
                    <th class="px-6 py-4">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-pink-100">
                <?php foreach ($data['bookings'] as $booking): ?>
                <tr class="hover:bg-white/30 transition">
                    <!-- คอลัมน์ 1: วันเวลา -->
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-700">
                            <?php echo date('d/m/Y H:i', strtotime($booking->start_date)); ?>
                        </div>
                        <div class="text-xs text-gray-500">
                            ถึง <?php echo date('d/m/Y H:i', strtotime($booking->end_date)); ?>
                        </div>
                    </td>

                    <!-- คอลัมน์ 2: รายละเอียด -->
                    <td class="px-6 py-4">
                        <div class="font-bold text-pink-700"><?php echo $booking->requester_name; ?></div>
                        <div class="text-gray-700 font-medium"><?php echo $booking->destination; ?></div>
                        <div class="text-xs text-gray-500 mt-1">เหตุผล: <?php echo $booking->purpose; ?></div>
                    </td>

                    <!-- คอลัมน์ 3: สถานะ -->
                    <td class="px-6 py-4">
                        <?php 
                            $statusColor = match($booking->status) {
                                'pending' => 'bg-yellow-200 text-yellow-800',
                                'staff_approved' => 'bg-blue-200 text-blue-800',
                                'director_approved' => 'bg-green-200 text-green-800',
                                'rejected' => 'bg-red-200 text-red-800',
                            };
                            $statusText = match($booking->status) {
                                'pending' => 'รอ จนท. ตรวจสอบ',
                                'staff_approved' => 'รอ ผอ. อนุมัติ',
                                'director_approved' => 'อนุมัติแล้ว',
                                'rejected' => 'ไม่อนุมัติ',
                            };
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $statusColor; ?>">
                            <?php echo $statusText; ?>
                        </span>
                        
                        <!-- แสดงข้อมูลรถเมื่อมีการระบุแล้ว -->
                        <?php if($booking->vehicle_name): ?>
                            <div class="mt-2 p-2 bg-white/50 rounded border border-pink-100">
                                <div class="text-xs font-bold text-pink-600">🚐 <?php echo $booking->vehicle_name; ?></div>
                                <div class="text-xs text-gray-600">คนขับ: <?php echo $booking->driver_name; ?></div>
                            </div>
                        <?php endif; ?>
                    </td>

                    <!-- คอลัมน์ 4: การจัดการ -->
                    <td class="px-6 py-4">
                        
                        <!-- 1. ส่วนของ Staff (เสนอ ผอ.) -->
                        <?php if($_SESSION['role'] == 'staff' && $booking->status == 'pending'): ?>
                            <form action="/booking/staffApprove" method="POST" class="space-y-2 bg-white/40 p-2 rounded border border-pink-100">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                
                                <select name="vehicle_id" class="w-full text-xs p-1 rounded border border-pink-300 bg-white" required>
                                    <option value="">-- เลือกรถ --</option>
                                    <?php foreach($data['vehicles'] as $v): ?>
                                        <option value="<?php echo $v->id; ?>">
                                            <?php echo $v->name; ?> (<?php echo $v->status == 'available' ? 'ว่าง' : 'ไม่ว่าง'; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                
                                <input type="text" name="driver_name" placeholder="ระบุชื่อคนขับ" class="w-full text-xs p-1 rounded border border-pink-300" required>
                                
                                <button type="submit" class="w-full bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 font-bold shadow-sm">
                                    เสนอ ผอ.
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- 2. ส่วนของ Director (อนุมัติ/ไม่อนุมัติ) -->
                        <?php if($_SESSION['role'] == 'admin' && $booking->status == 'staff_approved'): ?>
                            <form action="/booking/directorApprove" method="POST" class="flex gap-2 mt-2">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                <button type="submit" name="approval_status" value="approve" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 font-bold shadow-sm">
                                    ✓ อนุมัติ
                                </button>
                                <button type="submit" name="approval_status" value="reject" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 font-bold shadow-sm">
                                    ✗ ไม่อนุมัติ
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- 3. ปุ่มยกเลิก (เฉพาะเจ้าของรายการ และสถานะยังเป็น Pending) -->
                        <?php if(($booking->user_id == $_SESSION['user_id'] || $_SESSION['role'] == 'admin') && $booking->status == 'pending'): ?>
                            <form action="/booking/cancel" method="POST" class="inline-block mt-2" onsubmit="return confirmCancel(event)">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-red-200 transition flex items-center gap-1 border border-red-200">
                                    🗑️ ยกเลิก
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- 4. ปุ่มพิมพ์ใบขออนุญาต (เฉพาะที่อนุมัติแล้ว) -->
                        <?php if($booking->status == 'director_approved'): ?>
                            <a href="/booking/print/<?php echo $booking->id; ?>" target="_blank" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-gray-200 transition flex items-center gap-1 inline-block mt-2 border border-gray-300">
                                🖨️ พิมพ์
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script ยืนยันการยกเลิก -->
<script>
function confirmCancel(e) {
    e.preventDefault();
    var form = e.target;
    Swal.fire({
        title: 'ยืนยันการยกเลิก?',
        text: "คุณต้องการยกเลิกรายการจองนี้ใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ยกเลิกเลย',
        cancelButtonText: 'ไม่'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
}
</script>

<!-- Script DataTables -->
<script>
    $(document).ready(function() {
        $('#bookingTable').DataTable({
            responsive: true,
            "order": [], // ปิดการเรียง Default ให้ใช้ลำดับจาก SQL (ล่าสุดขึ้นก่อน)
            "language": {
                "lengthMenu": "แสดง _MENU_ รายการ",
                "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "info": "หน้า _PAGE_ จาก _PAGES_",
                "infoEmpty": "ไม่มีข้อมูล",
                "infoFiltered": "(กรองจาก _MAX_ รายการ)",
                "search": "🔍 ค้นหา:",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": "ถัดไป",
                    "previous": "ก่อนหน้า"
                }
            }
        });
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>