<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4">Selamat Datang, Admin!</h1>
        <p class="lead">Ini adalah halaman dashboard Anda. Anda dapat mengelola semua aspek sistem informasi PKL dari sini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75">Total Siswa Terdaftar</div>
                        <div class="h3 mb-0"><?= esc($totalSiswaTerdaftar); ?></div> <!-- Data nyata -->
                    </div>
                    <i class="fas fa-user-graduate fa-3x text-white-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('admin/siswa'); ?>">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75">Ajuan PKL Menunggu</div>
                        <div class="h3 mb-0"><?= esc($ajuanMenunggu); ?></div> <!-- Data nyata -->
                    </div>
                    <i class="fas fa-file-alt fa-3x text-white-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('admin/ajuan'); ?>">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75">Ajuan PKL Disetujui</div>
                        <div class="h3 mb-0"><?= esc($ajuanDisetujui); ?></div> <!-- Data nyata -->
                    </div>
                    <i class="fas fa-check-circle fa-3x text-white-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('admin/ajuan'); ?>">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Statistik Pengajuan PKL (Grafik Placeholder)
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
            <div class="card-footer small text-muted">Update hari ini</div>
        </div>
    </div>
</div>

<!-- Chart.js (Placeholder) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script>
    // Placeholder Chart.js code
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Jumlah Ajuan",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: [100, 120, 150, 130, 180, 200, 220, 250, 230, 280, 300, 320], // Dummy data
            }],
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 500, // Sesuaikan max
                        maxTicksLimit: 5
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, .075)",
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
</script>
