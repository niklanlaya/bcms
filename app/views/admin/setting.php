<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-pink-700 mb-6">⚙️ ตั้งค่าระบบ (System Settings)</h2>

    <form action="/setting/update" method="POST" enctype="multipart/form-data" class="glass p-8 space-y-6">
        
        <!-- ส่วนที่ 1: ข้อมูลทั่วไป -->
        <div class="border-b border-pink-200 pb-4 mb-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">📝 ข้อมูลเว็บไซต์</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อระบบ (Site Name)</label>
                    <input type="text" name="site_name" value="<?php echo $data['settings']->site_name; ?>" class="w-full p-2 rounded border border-pink-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อหน่วยงาน (School Name)</label>
                    <input type="text" name="school_name" value="<?php echo $data['settings']->school_name; ?>" class="w-full p-2 rounded border border-pink-200">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">ข้อความ Footer (Copyright)</label>
                    <input type="text" name="footer_text" value="<?php echo $data['settings']->footer_text; ?>" class="w-full p-2 rounded border border-pink-200">
                </div>
            </div>
        </div>

        <!-- ส่วนที่ 2: รูปภาพและธีม -->
        <div class="border-b border-pink-200 pb-4 mb-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">🎨 การแสดงผล (Theme)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo (อัปโหลดใหม่เพื่อเปลี่ยน)</label>
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    <?php if($data['settings']->logo_path): ?>
                        <img src="<?php echo $data['settings']->logo_path; ?>" class="h-12 mt-2 border border-gray-300 rounded">
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon (ไอคอนบน Tab)</label>
                    <input type="file" name="favicon" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    <?php if($data['settings']->favicon_path): ?>
                        <img src="<?php echo $data['settings']->favicon_path; ?>" class="h-8 w-8 mt-2 border border-gray-300 rounded">
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">สีธีมหลัก (Template Color)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="theme_color" value="<?php echo $data['settings']->theme_color; ?>" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                        <span class="text-xs text-gray-500">มีผลกับพื้นหลัง, ปุ่ม และหัวข้อ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ส่วนที่ 3: การแจ้งเตือน -->
        <div class="border-b border-pink-200 pb-4 mb-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">🔔 Telegram Notification</h3>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bot Token</label>
                    <input type="text" name="telegram_token" value="<?php echo $data['settings']->telegram_token; ?>" placeholder="123456:ABC-..." class="w-full p-2 rounded border border-pink-200 font-mono text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Chat ID</label>
                    <input type="text" name="telegram_chat_id" value="<?php echo $data['settings']->telegram_chat_id; ?>" placeholder="-123456789" class="w-full p-2 rounded border border-pink-200 font-mono text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-pink-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:bg-pink-700 transition transform hover:scale-105">
                💾 บันทึกการตั้งค่า
            </button>
        </div>

    </form>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>