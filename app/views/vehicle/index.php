<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-pink-700">🚌 จัดการข้อมูลยานพาหนะ</h2>
        <a href="/vehicle/create" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition font-bold">
            + เพิ่มรถใหม่
        </a>
    </div>

    <div class="glass overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-pink-500/20 text-pink-900 uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">ชื่อรถ / หมายเลข</th>
                    <th class="px-6 py-4">ทะเบียน</th>
                    <th class="px-6 py-4">ประเภท</th>
                    <th class="px-6 py-4">สถานะ</th>
                    <th class="px-6 py-4 text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-pink-100">
                <?php foreach ($data['vehicles'] as $v): ?>
                <tr class="hover:bg-white/30 transition">
                    <td class="px-6 py-4 font-bold text-gray-700"><?php echo $v->name; ?></td>
                    <td class="px-6 py-4"><?php echo $v->plate_number; ?></td>
                    <td class="px-6 py-4">
                        <?php echo $v->type == 'van' ? '🚐 รถตู้' : '🛻 รถกระบะ'; ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold <?php echo $v->status == 'available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                            <?php echo $v->status == 'available' ? 'พร้อมใช้งาน' : 'ส่งซ่อม/งดใช้'; ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <a href="/vehicle/edit/<?php echo $v->id; ?>" class="text-yellow-600 hover:text-yellow-800">✏️ แก้ไข</a>
                        
                        <form action="/vehicle/delete/<?php echo $v->id; ?>" method="POST" onsubmit="return confirm('ยืนยันการลบรถคันนี้?');">
                            <button type="submit" class="text-red-500 hover:text-red-700">🗑️ ลบ</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>