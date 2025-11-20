<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BCMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; background: linear-gradient(135deg, #fce7f3, #f472b6); }
        .glass { background: rgba(255,255,255,0.3); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body class="h-screen flex items-center justify-center">
    <div class="glass p-10 rounded-2xl shadow-2xl w-96">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-pink-700">เข้าสู่ระบบ</h1>
            <p class="text-gray-600 text-sm">ระบบจองรถยนต์ เตรียมอุดมฯ ภาคเหนือ</p>
        </div>
        <form action="/auth/authenticate" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" class="w-full p-3 rounded-lg bg-white/50 border-none focus:ring-2 focus:ring-pink-400 outline-none" placeholder="teacher / staff / director">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full p-3 rounded-lg bg-white/50 border-none focus:ring-2 focus:ring-pink-400 outline-none" placeholder="password">
            </div>
            <button type="submit" class="w-full bg-pink-600 text-white font-bold py-3 rounded-lg hover:bg-pink-700 transition shadow-lg">
                Login
            </button>
            <div class="text-center mt-4">
                <a href="/" class="text-sm text-pink-800 hover:underline">กลับหน้าปฏิทิน</a>
            </div>
        </form>
    </div>
</body>
</html>