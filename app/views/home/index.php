<?php require_once '../app/views/layout/header.php'; ?>

<!-- กรณี User ยังไม่ Login ให้แสดงปุ่ม Login ที่มุมขวาบน -->
<?php if(!isset($_SESSION['user_id'])): ?>
    <div class="absolute top-4 right-4 z-50">
        <a href="/auth/login" class="glass px-6 py-2 text-pink-600 font-bold hover:bg-white/60 transition flex items-center gap-2">
            <span>🔒</span> เข้าสู่ระบบบุคลากร
        </a>
    </div>
<?php else: ?>
    <?php require_once '../app/views/layout/sidebar.php'; ?>
<?php endif; ?>

<!-- ปรับ container เป็น w-full และเพิ่ม padding เล็กน้อย -->
<div class="w-full px-2 md:px-4 h-full flex flex-col">
    
    <!-- Header ย่อขนาดลงเล็กน้อยเพื่อให้เหลือพื้นที่ให้ปฏิทิน -->
    <div class="text-center mb-4 md:mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-pink-800 drop-shadow-sm">ตารางการใช้รถยนต์ราชการ</h1>
        <p class="text-sm text-pink-700 opacity-80">โรงเรียนเตรียมอุดมศึกษา ภาคเหนือ จังหวัดพิษณุโลก</p>
    </div>

    <!-- 
        1. ลบ max-w-5xl ออก
        2. เพิ่ม min-h-[80vh] เพื่อบังคับให้สูงอย่างน้อย 80% ของหน้าจอ
        3. ใช้ flex เพื่อจัด layout ภายใน
    -->
    <div class="glass p-4 md:p-6 w-full min-h-[80vh] flex flex-col shadow-xl">
        <!-- ปฏิทินจะขยายเต็มพื้นที่ของ parent -->
        <div id='calendar' class="flex-grow w-full h-full text-sm md:text-base"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'th',
            // ปรับความสูงให้พอดีกับ container อัตโนมัติ
            height: '100%', 
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            buttonText: {
                today:    'วันนี้',
                month:    'เดือน',
                week:     'สัปดาห์',
                day:      'วัน',
                list:     'รายการ'
            },
            events: <?php echo $data['events']; ?>,
            eventClick: function(info) {
                // จัดรูปแบบวันที่ให้สวยงาม
                let start = info.event.start.toLocaleString('th-TH', { dateStyle: 'medium', timeStyle: 'short' });
                let end = info.event.end ? info.event.end.toLocaleString('th-TH', { dateStyle: 'medium', timeStyle: 'short' }) : '-';

                Swal.fire({
                    title: '<span class="text-pink-600">' + info.event.title + '</span>',
                    html: `
                        <div class="text-left space-y-2">
                            <p><strong>🕒 เริ่ม:</strong> ${start}</p>
                            <p><strong>🏁 สิ้นสุด:</strong> ${end}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#db2777',
                    confirmButtonText: 'ปิดหน้าต่าง'
                });
            },
            // เพิ่ม Effect ให้ event ดูน่าสนใจขึ้น
            eventDidMount: function(info) {
                info.el.style.cursor = 'pointer';
                info.el.title = info.event.title;
            }
        });
        calendar.render();
    });
</script>

<!-- เรียกใช้ Footer -->
<?php if(isset($_SESSION['user_id'])) require_once '../app/views/layout/footer.php'; ?>
<?php if(!isset($_SESSION['user_id'])) echo '</body></html>'; ?>