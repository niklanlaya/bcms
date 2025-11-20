<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-pink-700">👥 จัดการผู้ใช้งาน (บุคลากร)</h2>
        <a href="/user/create" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition font-bold">
            + เพิ่มบุคลากร
        </a>
    </div>

    <div class="glass overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-pink-500/20 text-pink-900 uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">ชื่อ-สกุล</th>
                    <th class="px-6 py-4">Username</th>
                    <th class="px-6 py-4">ตำแหน่ง / แผนก</th>
                    <th class="px-6 py-4">สิทธิ์ (Role)</th>
                    <th class="px-6 py-4 text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-pink-100">
                <?php foreach ($data['users'] as $u): ?>
                <tr class="hover:bg-white/30 transition">
                    <td class="px-6 py-4 font-bold"><?php echo $u->fullname; ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo $u->username; ?></td>
                    <td class="px-6 py-4">
                        <div><?php echo $u->position; ?></div>
                        <div class="text-xs text-gray-500"><?php echo $u->department; ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold 
                            <?php 
                                echo match($u->role) {
                                    'admin' => 'bg-purple-200 text-purple-800',
                                    'staff' => 'bg-blue-200 text-blue-800',
                                    default => 'bg-gray-200 text-gray-800'
                                };
                            ?>">
                            <?php echo strtoupper($u->role); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <a href="/user/edit/<?php echo $u->id; ?>" class="text-yellow-600 hover:text-yellow-800">✏️ แก้ไข</a>
                        <?php if($u->id != $_SESSION['user_id']): ?>
                        <form action="/user/delete/<?php echo $u->id; ?>" method="POST" onsubmit="return confirm('ยืนยันการลบผู้ใช้นี้?');">
                            <button type="submit" class="text-red-500 hover:text-red-700">🗑️ ลบ</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>