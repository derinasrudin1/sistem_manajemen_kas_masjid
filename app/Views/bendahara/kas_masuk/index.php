<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kas Masuk
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
<li class="breadcrumb-item active">Kas Masuk</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-hand-holding-usd"></i>
                    Data Kas Masuk
                </h3>
            </div>
            <div class="card-body">

                <!-- Tombol Tambah Data di Kiri Atas -->
                <a href="<?= base_url('bendahara/kas-masuk/create') ?>" class="btn btn-success mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah Kas Masuk
                </a>

                <!-- Notifikasi Flash Message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table id="kasMasukTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Sumber Dana</th>
                                <th>Keterangan</th>
                                <th>Dicatat Oleh</th> <!-- KOLOM BARU -->
                                <th class="text-center no-export">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kas_masuk)): ?>
                                <?php foreach ($kas_masuk as $i => $kas): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= date('d M Y', strtotime($kas['tanggal'])) ?></td>
                                        <td>Rp <?= number_format($kas['jumlah'], 0, ',', '.') ?></td>
                                        <!-- PERUBAHAN: Menampilkan nama_sumber dari hasil JOIN -->
                                        <td><?= esc($kas['nama_sumber']) ?></td>
                                        <td><?= esc($kas['keterangan']) ?></td>
                                        <!-- KOLOM BARU: Menampilkan nama user dari hasil JOIN -->
                                        <td><?= esc($kas['nama_user']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('bendahara/kas-masuk/edit/' . $kas['id_kas_masuk']) ?>"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-delete-url="<?= base_url('bendahara/kas-masuk/delete/' . $kas['id_kas_masuk']) ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <!-- PERUBAHAN: Colspan disesuaikan menjadi 7 -->
                                    <td colspan="7" class="text-center">Belum ada data kas masuk.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Sumber Dana</th>
                                <th>Keterangan</th>
                                <th>Dicatat Oleh</th> <!-- KOLOM BARU -->
                                <th class="text-center">Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini? Proses ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="POST">
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<style>
    .dt-buttons {
        width: 100%;
        text-align: center;
        margin-bottom: 1rem;
    }

    .dt-buttons .btn {
        margin: 0 5px;
        /* Memberi jarak antar tombol ekspor */
    }
</style>
<script>
    // Skrip untuk Modal Hapus
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const deleteUrl = button.getAttribute('data-delete-url');
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.setAttribute('action', deleteUrl);
            });
        }
    });

    // Inisialisasi DataTables dengan tata letak yang sudah diperbaiki
    $(document).ready(function () {
        $('#kasMasukTable').DataTable({
            // Tata letak kontrol DataTables
            // B (Tombol Ekspor) berada di barisnya sendiri, di atas tabel
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Salin', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'print', text: '<i class="fas fa-print"></i> Cetak', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json"
            }
        });
    });
</script>
<?= $this->endSection() ?>