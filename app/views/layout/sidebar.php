<?php if(isset($_SESSION['user_id'])): ?>
<aside class="w-64 min-h-screen sidebar-glass border-r border-white/30 hidden md:block fixed z-10">
    
    <!-- ส่วนหัว Sidebar (Logo & User) -->
    <div class="p-6 text-center">
        <!-- 1. แสดง Logo (ถ้ามี) หรือแสดง Placeholder -->
        <?php if(isset($sysConfig) && !empty($sysConfig->logo_path)): ?>
            <img src="<?php echo $sysConfig->logo_path; ?>" class="w-24 h-24 mx-auto object-contain mb-4 drop-shadow-md bg-white rounded-full p-1">
        <?php else: ?>
            <div class="w-20 h-20 mx-auto bg-pink-200 text-pink-600 rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-inner border-2 border-white">
                ต.อ.
            </div>
        <?php endif; ?>

        <h2 class="text-lg font-bold text-pink-700 truncate"><?php echo $sysConfig->site_name; ?></h2>
        <p class="text-sm text-gray-600 truncate px-2"><?php echo $_SESSION['user_name']; ?></p>
        <span class="text-xs bg-pink-100 text-pink-800 px-2 py-1 rounded-full uppercase font-bold tracking-wider mt-1 inline-block">
            <?php echo $_SESSION['role']; ?>
        </span>
    </div>
    
    <!-- เมนูนำทาง -->
    <nav class="mt-2 pb-20 overflow-y-auto h-[calc(100vh-300px)]">
        
        <!-- 1. เมนูทั่วไป (เข้าได้ทุกคน) -->
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

        <!-- 2. ส่วนผู้ดูแลระบบ (Staff & Admin) -->
        <?php if($_SESSION['role'] == 'staff' || $_SESSION['role'] == 'admin'): ?>
        <div class="mt-4 mb-2 px-6 text-xs text-pink-800 font-bold opacity-50 uppercase tracking-wider">
            งานยานพาหนะ
        </div>
        <a href="/vehicle" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            🚌 จัดการยานพาหนะ
        </a>
        <?php endif; ?>

        <!-- 3. ส่วนแอดมินสูงสุด (Admin Only) -->
        <?php if($_SESSION['role'] == 'admin'): ?>
        <div class="mt-4 mb-2 px-6 text-xs text-pink-800 font-bold opacity-50 uppercase tracking-wider">
            ผู้ดูแลระบบ
        </div>
        <a href="/user" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            👥 จัดการผู้ใช้งาน
        </a>
        <a href="/setting" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            ⚙️ ตั้งค่าระบบ
        </a>
        <?php endif; ?>

        <!-- 4. ส่วนตัว (ทุกคน) -->
        <div class="mt-4 mb-2 px-6 text-xs text-pink-800 font-bold opacity-50 uppercase tracking-wider">
            ส่วนตัว
        </div>
        
        <a href="/user/profile" class="block py-3 px-6 hover:bg-white/50 transition text-gray-700 border-l-4 border-transparent hover:border-pink-500">
            ⚙️ ข้อมูลส่วนตัว / รหัสผ่าน
        </a>

        <a href="/auth/logout" class="block py-3 px-6 hover:bg-red-100 transition text-red-600 mt-2 border-l-4 border-transparent hover:border-red-500">
            🚪 ออกจากระบบ
        </a>
    </nav>
</aside>
<div class="w-64 hidden md:block"></div> <!-- Spacer สำหรับดันเนื้อหาหลัก -->
<?php endif; ?>

<div class="flex-1 flex flex-col min-h-screen">
    <!-- Mobile Header (แสดงเมื่อจอเล็ก) -->
    <div class="md:hidden glass p-4 flex justify-between items-center sticky top-0 z-20 m-2 shadow-lg">
        <div class="flex items-center gap-2">
            <?php if(isset($sysConfig) && !empty($sysConfig->logo_path)): ?>
                <img src="<?php echo $sysConfig->logo_path; ?>" class="w-8 h-8 object-contain">
            <?php endif; ?>
            <span class="font-bold text-pink-600 truncate w-32"><?php echo isset($sysConfig) ? $sysConfig->site_name : 'BCMS'; ?></span>
        </div>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="flex gap-3 text-sm items-center">
                <a href="/user/profile" class="text-gray-600 hover:text-pink-600 flex flex-col items-center">
                    <span class="text-xs">👤 ส่วนตัว</span>
                </a>
                <a href="/auth/logout" class="text-red-500 hover:text-red-700 flex flex-col items-center border-l pl-3 border-gray-300">
                    <span class="text-xs">ออก</span>
                </a>
            </div>
        <?php else: ?>
            <a href="/auth/login" class="text-sm font-bold text-pink-500 bg-white/80 px-3 py-1 rounded-full shadow">🔒 Login</a>
        <?php endif; ?>
    </div>
    <main class="p-4 md:p-8 flex-grow">