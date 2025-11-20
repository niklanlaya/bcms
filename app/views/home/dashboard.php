<?php require_once '../app/views/layout/header.php'; ?>
<?php require_once '../app/views/layout/sidebar.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="w-full space-y-6">
    <h2 class="text-2xl font-bold text-pink-700">📊 แดชบอร์ดสรุปข้อมูล</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Card 1: สถานะการจอง -->
        <div class="glass p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">สถานะการดำเนินการ</h3>
            <div class="h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Card 2: การใช้รถแต่ละคัน -->
        <div class="glass p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">สถิติการใช้รถแต่ละคัน (เที่ยว)</h3>
            <div class="h-64">
                <canvas id="vehicleChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // เตรียมข้อมูลจาก PHP -> JS
    const statusData = <?php echo json_encode($data['statusData']); ?>;
    const vehicleData = <?php echo json_encode($data['vehicleData']); ?>;

    // 1. กราฟโดนัท (สถานะ)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: statusData.map(item => item.status),
            datasets: [{
                data: statusData.map(item => item.count),
                backgroundColor: ['#fbbf24', '#60a5fa', '#4ade80', '#f87171'], // เหลือง ฟ้า เขียว แดง
                borderWidth: 0
            }]
        },
        options: { maintainAspectRatio: false }
    });

    // 2. กราฟแท่ง (รถ)
    const ctxVehicle = document.getElementById('vehicleChart').getContext('2d');
    new Chart(ctxVehicle, {
        type: 'bar',
        data: {
            labels: vehicleData.map(item => item.name),
            datasets: [{
                label: 'จำนวนครั้งที่ออกปฏิบัติงาน',
                data: vehicleData.map(item => item.count),
                backgroundColor: 'rgba(219, 39, 119, 0.6)', // Pink
                borderColor: 'rgba(219, 39, 119, 1)',
                borderWidth: 1
            }]
        },
        options: { 
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>