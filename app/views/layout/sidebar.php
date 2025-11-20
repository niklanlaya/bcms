<?php if(isset($_SESSION['user_id'])): ?>
<aside class="w-64 min-h-screen sidebar-glass border-r border-white/30 hidden md:block fixed z-10">
    <div class="p-6 text-center">
        <div class="w-20 h-20 mx-auto bg-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 shadow-lg">
            ต.อ.
        </div>
        <h2 class="text-lg font-bold text-pink-700">BCMS System</h2>
        <p class="text-sm text-gray-600"><?php echo $_SESSION['user_name']; ?></p>
        <span class="text-xs bg-pink-200 text-pink-800 px-2 py-1 rounded-full"><?php echo strtoupper($_SESSION['role']); ?></span>
    </div>
    <nav class="mt-6">
        <a href="/home/dashboard" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            📊 แดชบอร์ด / สถิติ
        </a>
        <a href="/" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            📅 ปฏิทินการใช้รถ
        </a>
        <a href="/booking" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            📝 รายการจอง / อนุมัติ
        </a>
        <a href="/booking/create" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            ➕ จองรถใหม่
        </a>
        
        <?php if($_SESSION['role'] == 'staff' || $_SESSION['role'] == 'admin'): ?>
        <div class="mt-4 mb-2 px-6 text-xs text-pink-800 font-bold opacity-50 uppercase tracking-wider">
            ผู้ดูแลระบบ
        </div>
        <a href="/vehicle" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            🚌 จัดการยานพาหนะ

            <!-- ต่อจากเมนู จัดการยานพาหนะ -->
        <?php if($_SESSION['role'] == 'admin'): ?>
        <a href="/user" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
        👥 จัดการผู้ใช้งาน
    </a>
    <?php endif; ?>
    
    <!-- ย้ายปุ่ม Profile มาไว้ท้ายสุดก่อน Logout -->
    <a href="/user/profile" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500 mt-4 border-t border-pink-100">
        👤 ข้อมูลส่วนตัว / เปลี่ยนรหัส
    </a>
        </a>
        <?php endif; ?>
        
        <a href="/auth/logout" class="block py-3 px-6 hover:bg-red-100 transition text-red-600 mt-10">
            🚪 ออกจากระบบ
        </a>
    </nav>

</aside>
<div class="w-64 hidden md:block"></div> <!-- Spacer -->
<?php endif; ?>

<div class="flex-1 flex flex-col">
    <!-- Mobile Header -->
    <div class="md:hidden glass p-4 flex justify-between items-center sticky top-0 z-20 m-2">
        <span class="font-bold text-pink-600">BCMS</span>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/auth/logout" class="text-sm text-red-500">Logout</a>
        <?php else: ?>
            <a href="/auth/login" class="text-sm text-pink-500">Login</a>
        <?php endif; ?>
    </div>
    <main class="p-4 md:p-8">