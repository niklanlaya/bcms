</main> <!-- ปิดส่วนเนื้อหาหลัก (Main) ที่เปิดใน Sidebar -->

        <!-- ส่วน Footer ด้านล่าง -->
        <footer class="mt-auto py-6 text-center glass m-4 mx-8">
            <p class="text-sm text-pink-500 font-medium">
                <?php echo isset($sysConfig) ? $sysConfig->footer_text : '© ระบบจองยานพาหนะ (BCMS)'; ?>
            </p>
            <p class="text-xs text-pink-400 mt-1">
                <?php echo isset($sysConfig) ? $sysConfig->school_name : ''; ?>
            </p>
        </footer>

    </div> <!-- ปิด Wrapper (Flex-1) ที่เปิดใน Sidebar -->

    <!-- Script สำหรับ SweetAlert2 (แจ้งเตือน Popup) -->
    <!-- โค้ดนี้จะทำงานเมื่อ Controller ส่งค่า $_SESSION['alert'] มาให้ -->
    <?php if(isset($_SESSION['alert'])): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['alert']['type']; ?>', // success, error, warning
            title: '<?php echo $_SESSION['alert']['type'] == 'success' ? 'สำเร็จ' : 'แจ้งเตือน'; ?>',
            text: '<?php echo $_SESSION['alert']['msg']; ?>',
            confirmButtonColor: '#db2777', // สีชมพูเข้ม
            confirmButtonText: 'ตกลง',
            timer: 3000, // ปิดเองใน 3 วินาที
            timerProgressBar: true
        });
    </script>
    <?php unset($_SESSION['alert']); // ลบค่าทิ้ง เพื่อไม่ให้เด้งซ้ำเมื่อ Refresh ?>
    <?php endif; ?>

</body>
</html>