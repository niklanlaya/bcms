<?php 
require_once '../app/views/layout/header.php'; 
require_once '../app/views/layout/sidebar.php'; 

$isEdit = isset($data['user']);
$u = $isEdit ? $data['user'] : null;
$action = $isEdit ? "/user/update/" . $u->id : "/user/store";
?>

<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-pink-700 mb-6">
        <?php echo $isEdit ? '✏️ แก้ไขข้อมูลผู้ใช้งาน' : '➕ เพิ่มผู้ใช้งานใหม่'; ?>
    </h2>
    
    <form action="<?php echo $action; ?>" method="POST" class="glass p-8 space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username (สำหรับ Login)</label>
                <input type="text" name="username" value="<?php echo $u->username ?? ''; ?>" required class="w-full p-2 rounded border border-pink-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" <?php echo $isEdit ? '' : 'required'; ?> class="w-full p-2 rounded border border-pink-200" placeholder="<?php echo $isEdit ? 'เว้นว่างไว้ถ้าไม่ต้องการเปลี่ยน' : ''; ?>">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อ-นามสกุล</label>
            <input type="text" name="fullname" value="<?php echo $u->fullname ?? ''; ?>" required class="w-full p-2 rounded border border-pink-200">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ตำแหน่ง</label>
                <input type="text" name="position" value="<?php echo $u->position ?? ''; ?>" class="w-full p-2 rounded border border-pink-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">กลุ่มสาระ / งาน</label>
                <input type="text" name="department" value="<?php echo $u->department ?? ''; ?>" class="w-full p-2 rounded border border-pink-200">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">สิทธิ์การใช้งาน (Role)</label>
            <select name="role" class="w-full p-2 rounded border border-pink-200">
                <option value="user" <?php echo ($u->role ?? '') == 'user' ? 'selected' : ''; ?>>User (ครู/บุคลากรทั่วไป)</option>
                <option value="staff" <?php echo ($u->role ?? '') == 'staff' ? 'selected' : ''; ?>>Staff (เจ้าหน้าที่ยานพาหนะ)</option>
                <option value="admin" <?php echo ($u->role ?? '') == 'admin' ? 'selected' : ''; ?>>Admin (ผู้อำนวยการ / ผู้ดูแลระบบ)</option>
            </select>
        </div>

        <div class="pt-4 border-t border-pink-200 flex justify-between">
            <a href="/user" class="text-gray-500 hover:underline self-center">ย้อนกลับ</a>
            <button type="submit" class="bg-pink-600 text-white font-bold py-2 px-6 rounded shadow hover:bg-pink-700 transition">
                บันทึกข้อมูล
            </button>
        </div>
    </form>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>