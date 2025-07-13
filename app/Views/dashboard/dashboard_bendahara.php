<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>Rp <?= number_format($total_masuk ?? 0, 0, ',', '.') ?></h3>
                        <p>Total Kas Masuk</p>
                    </div>
                    <div class="icon"><i class="nav-icon fas fa-arrow-down"></i></div><a href="/kasmasuk"
                        class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Rp <?= number_format($total_keluar ?? 0, 0, ',', '.') ?></h3>
                        <p>Total Kas Keluar</p>
                    </div>
                    <div class="icon"><i class="nav-icon fas fa-arrow-up"></i></div><a href="/kaskeluar"
                        class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rp <?= number_format($sisa_saldo ?? 0, 0, ',', '.') ?></h3>
                        <p>Sisa Saldo</p>
                    </div>
                    <div class="icon"><i class="ion ion-stats-bars"></i></div><a href="#" class="small-box-footer">More
                        info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $persentase ?? 0 ?>%</h3>
                        <p>Saldo Terhadap Pemasukan</p>
                    </div>
                    <div class="icon"><i class="ion ion-pie-graph"></i></div><a href="#" class="small-box-footer">More
                        info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp <?= number_format($total_masuk_bulan_ini ?? 0, 0, ',', '.') ?></h3>
                        <p>Pemasukan (<?= $periode_bulan_ini ?? 'Bulan Ini' ?>)</p>
                    </div>
                    <div class="icon"><i class="fas fa-arrow-down"></i></div>
                    <a href="<?= base_url('bendahara/kas-masuk') ?>" class="small-box-footer">Lihat Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp <?= number_format($total_keluar_bulan_ini ?? 0, 0, ',', '.') ?></h3>
                        <p>Pengeluaran (<?= $periode_bulan_ini ?? 'Bulan Ini' ?>)</p>
                    </div>
                    <div class="icon"><i class="fas fa-arrow-up"></i></div>
                    <a href="<?= base_url('bendahara/kas-keluar') ?>" class="small-box-footer">Lihat Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Grafik Batang -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="far fa-chart-bar"></i> Grafik Keuangan Setahun Terakhir</h3>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 320px; width: 100%;"><canvas id="financialBarChart"></canvas>
                </div>
            </div>
        </div>
        <!-- /.card -->
        <!--Pie Chart Bulanan -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie"></i> Pemasukan (<?= $periode_bulan_ini ?>)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 320px; width: 100%;"><canvas
                                id="pemasukanPieChartBulanan"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie"></i> Pengeluaran (<?= $periode_bulan_ini ?>)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 320px; width: 100%;"><canvas
                                id="pengeluaranPieChartBulanan"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie"></i> Komposisi Sumber Pemasukan</h3>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 320px; width: 100%;"><canvas
                                id="pemasukanPieChart"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie"></i> Alokasi Dana Pengeluaran</h3>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 320px; width: 100%;"><canvas
                                id="pengeluaranPieChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?= $this->endSection() ?>


<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    // Ambil semua data dari PHP
    const barChartData = <?= json_encode($barChartData ?? []) ?>;
    const piePemasukanData = <?= json_encode($pieChartPemasukan ?? []) ?>;
    const piePengeluaranData = <?= json_encode($pieChartPengeluaran ?? []) ?>;
    const piePemasukanBulananData = <?= json_encode($pieChartPemasukanBulanan ?? []) ?>;
    const piePengeluaranBulananData = <?= json_encode($pieChartPengeluaranBulanan ?? []) ?>;


    // Fungsi pembantu (helper) untuk format Rupiah
    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
    }

    // Fungsi pembantu untuk memberi warna acak pada pie chart
    function generatePieColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const hue = (360 / count) * i;
            colors.push(`hsl(${hue}, 75%, 60%)`);
        }
        return colors;
    }

    document.addEventListener("DOMContentLoaded", function () {

        // --- GAMBAR GRAFIK BATANG 
        if (barChartData && barChartData.labels && barChartData.labels.length > 0) {
            const barCtx = document.getElementById('financialBarChart').getContext('2d');
            new Chart(barCtx, { type: 'bar', data: barChartData, options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { callback: formatRupiah } } }, plugins: { tooltip: { callbacks: { label: (context) => `${context.dataset.label}: ${formatRupiah(context.parsed.y)}` } } } } });
        }

        // --- GAMBAR PIE CHART PEMASUKAN BULANAN ---
        if (piePemasukanBulananData && piePemasukanBulananData.datasets[0].data.length > 0) {
            piePemasukanBulananData.datasets[0].backgroundColor = generatePieColors(piePemasukanBulananData.datasets[0].data.length);
            const ctx = document.getElementById('pemasukanPieChartBulanan').getContext('2d');
            new Chart(ctx, {
                type: 'pie', data: piePemasukanBulananData, options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((sum, current) => sum + current, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${formatRupiah(value)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }

            });
        } else {
            const ctx = document.getElementById('pemasukanPieChartBulanan').getContext('2d');
            ctx.font = '16px Arial'; ctx.textAlign = 'center';
            ctx.fillText('Tidak ada data pemasukan bulan ini.', ctx.canvas.width / 2, ctx.canvas.height / 2);
        }

        // --- GAMBAR PIE CHART PENGELUARAN BULANAN ---
        if (piePengeluaranBulananData && piePengeluaranBulananData.datasets[0].data.length > 0) {
            piePengeluaranBulananData.datasets[0].backgroundColor = generatePieColors(piePengeluaranBulananData.datasets[0].data.length);
            const ctx = document.getElementById('pengeluaranPieChartBulanan').getContext('2d');
            new Chart(ctx, {
                type: 'pie', data: piePengeluaranBulananData, options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((sum, current) => sum + current, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${formatRupiah(value)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        } else {
            const ctx = document.getElementById('pengeluaranPieChartBulanan').getContext('2d');
            ctx.font = '16px Arial'; ctx.textAlign = 'center';
            ctx.fillText('Tidak ada data pengeluaran bulan ini.', ctx.canvas.width / 2, ctx.canvas.height / 2);
        }

        // --- GAMBAR PIE CHART PEMASUKAN ---
        if (piePemasukanData && piePemasukanData.datasets[0].data.length > 0) {
            piePemasukanData.datasets[0].backgroundColor = generatePieColors(piePemasukanData.datasets[0].data.length);
            const pemasukanCtx = document.getElementById('pemasukanPieChart').getContext('2d');
            new Chart(pemasukanCtx, {
                type: 'pie',
                data: piePemasukanData,
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((sum, current) => sum + current, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${formatRupiah(value)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        } else { }

        // --- GAMBAR PIE CHART PENGELUARAN ---
        if (piePengeluaranData && piePengeluaranData.datasets[0].data.length > 0) {
            piePengeluaranData.datasets[0].backgroundColor = generatePieColors(piePengeluaranData.datasets[0].data.length);
            const pengeluaranCtx = document.getElementById('pengeluaranPieChart').getContext('2d');
            new Chart(pengeluaranCtx, {
                type: 'pie',
                data: piePengeluaranData,
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((sum, current) => sum + current, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${formatRupiah(value)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        } else { }
    });
</script>
<?= $this->endSection() ?>