<?php 
require_once '../app/views/layout/header.php'; 
require_once '../app/views/layout/sidebar.php'; 

// เช็คว่าเป็นโหมดแก้ไขหรือไม่
$isEdit = isset($data['vehicle']);
$v = $isEdit ? $data['vehicle'] : null;
$action = $isEdit ? "/vehicle/update/" . $v->id : "/vehicle/store";
?>

<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-pink-700 mb-6">
        <?php echo $isEdit ? '✏️ แก้ไขข้อมูลรถ' : '➕ เพิ่มรถใหม่'; ?>
    </h2>
    
    <form action="<?php echo $action; ?>" method="POST" class="glass p-8 space-y-6">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อเรียก (เช่น รถตู้ 1)</label>
            <input type="text" name="name" value="<?php echo $v->name ?? ''; ?>" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">หมายเลขทะเบียน</label>
            <input type="text" name="plate_number" value="<?php echo $v->plate_number ?? ''; ?>" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ประเภทรถ</label>
                <select name="type" class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="van" <?php echo ($v->type ?? '') == 'van' ? 'selected' : ''; ?>>รถตู้</option>
                    <option value="pickup" <?php echo ($v->type ?? '') == 'pickup' ? 'selected' : ''; ?>>รถกระบะ</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">สถานะปัจจุบัน</label>
                <select name="status" class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="available" <?php echo ($v->status ?? '') == 'available' ? 'selected' : ''; ?>>พร้อมใช้งาน</option>
                    <option value="maintenance" <?php echo ($v->status ?? '') == 'maintenance' ? 'selected' : ''; ?>>ซ่อมบำรุง / งดใช้</option>
                </select>
            </div>
        </div>

        <div class="pt-4 border-t border-pink-200 flex justify-between">
            <a href="/vehicle" class="text-gray-500 hover:underline self-center">ย้อนกลับ</a>
            <button type="submit" class="bg-pink-600 text-white font-bold py-2 px-6 rounded-lg shadow hover:bg-pink-700 transition">
                บันทึกข้อมูล
            </button>
        </div>
    </form>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>