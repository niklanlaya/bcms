<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="w-full">
    <h2 class="text-2xl font-bold text-pink-700 mb-6">รายการจองยานพาหนะ</h2>

    <div class="glass overflow-hidden">
        <table class="min-w-full text-sm text-left">
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
                    <td class="px-6 py-4">
                        <div><?php echo date('d/m/Y H:i', strtotime($booking->start_date)); ?></div>
                        <div class="text-xs text-gray-500">ถึง <?php echo date('d/m/Y H:i', strtotime($booking->end_date)); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold"><?php echo $booking->requester_name; ?></div>
                        <div class="text-gray-600"><?php echo $booking->destination; ?></div>
                        <div class="text-xs text-gray-500">เหตุผล: <?php echo $booking->purpose; ?></div>
                    </td>
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
                        <?php if($booking->vehicle_name): ?>
                            <div class="mt-1 text-xs font-bold text-pink-600">รถ: <?php echo $booking->vehicle_name; ?></div>
                            <div class="text-xs">คนขับ: <?php echo $booking->driver_name; ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <!-- Staff Approval Section -->
                        <?php if($_SESSION['role'] == 'staff' && $booking->status == 'pending'): ?>
                            <form action="/booking/staffApprove" method="POST" class="space-y-2">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                <select name="vehicle_id" class="w-full text-xs p-1 rounded border border-pink-300" required>
                                    <option value="">-- เลือกรถ --</option>
                                    <?php foreach($data['vehicles'] as $v): ?>
                                        <option value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" name="driver_name" placeholder="ชื่อคนขับ" class="w-full text-xs p-1 rounded border border-pink-300" required>
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 w-full">เสนอ ผอ.</button>
                            </form>
                        <?php endif; ?>

                        <!-- Director Approval Section -->
                        <?php if($_SESSION['role'] == 'admin' && $booking->status == 'staff_approved'): ?>
                            <form action="/booking/directorApprove" method="POST" class="flex gap-2">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                <button type="submit" name="approval_status" value="approve" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">อนุมัติ</button>
                                <button type="submit" name="approval_status" value="reject" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">ไม่อนุมัติ</button>
                            </form>
                        <?php endif; ?>

                        <!-- [เพิ่มใหม่] ปุ่มยกเลิก (แสดงเฉพาะเจ้าของรายการ และสถานะต้องเป็น pending) -->
                        <?php if($booking->user_id == $_SESSION['user_id'] && $booking->status == 'pending'): ?>
                            <form action="/booking/cancel" method="POST" class="inline-block" onsubmit="return confirmCancel(event)">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-red-200 transition flex items-center gap-1">
                                    ❌ ยกเลิก
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

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

<?php require_once '../app/views/layout/footer.php'; ?>