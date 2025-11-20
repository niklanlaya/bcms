<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="max-w-md mx-auto mt-10">
    <div class="glass p-8 text-center">
        <div class="w-24 h-24 bg-pink-200 rounded-full mx-auto flex items-center justify-center text-4xl mb-4">
            👤
        </div>
        <h2 class="text-xl font-bold text-pink-700"><?php echo $_SESSION['user_name']; ?></h2>
        <p class="text-gray-500 mb-6"><?php echo ucfirst($_SESSION['role']); ?></p>

        <hr class="border-pink-200 mb-6">

        <h3 class="text-left font-bold text-gray-700 mb-4">🔑 เปลี่ยนรหัสผ่าน</h3>
        <form action="/user/updatePassword" method="POST" class="space-y-4 text-left">
            <div>
                <label class="text-sm text-gray-600">รหัสผ่านใหม่</label>
                <input type="password" name="new_password" required class="w-full p-2 rounded border border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
            </div>
            <div>
                <label class="text-sm text-gray-600">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" name="confirm_password" required class="w-full p-2 rounded border border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
            </div>
            <button type="submit" class="w-full bg-pink-600 text-white py-2 rounded font-bold hover:bg-pink-700">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>