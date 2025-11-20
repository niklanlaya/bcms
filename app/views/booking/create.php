<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-pink-700 mb-6">📝 เขียนแบบขออนุญาตใช้รถยนต์</h2>
    
    <form action="/booking/store" method="POST" class="glass p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ขออนุญาตใช้วันที่</label>
                <input type="datetime-local" name="start_date" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ถึงวันที่</label>
                <input type="datetime-local" name="end_date" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">เพื่อ (วัตถุประสงค์)</label>
            <textarea name="purpose" rows="3" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="ระบุรายละเอียดภารกิจ..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">สถานที่ (Destination)</label>
            <input type="text" name="destination" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="ระบุสถานที่...">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">จำนวนผู้โดยสาร (คน)</label>
            <input type="number" name="passengers" required class="w-full p-2 rounded-lg border border-pink-200 bg-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>

        <div class="pt-4 border-t border-pink-200">
            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold py-3 rounded-lg shadow-lg hover:scale-105 transition transform">
                บันทึกการจอง
            </button>
        </div>
    </form>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>