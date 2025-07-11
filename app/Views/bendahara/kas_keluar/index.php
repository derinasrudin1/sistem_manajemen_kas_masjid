<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kas Keluar
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kas Keluar</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-invoice-dollar"></i> Data Kas Keluar</h3>
            </div>
            <div class="card-body">
                <a href="<?= base_url('bendahara/kas-keluar/create') ?>" class="btn btn-danger mb-3"><i
                        class="fas fa-plus-circle"></i> Tambah Kas Keluar</a>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table id="kasKeluarTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Dicatat Oleh</th>
                                <th class="text-center no-export">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kas_keluar)): ?>
                                <?php foreach ($kas_keluar as $i => $kas): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= date('d M Y', strtotime($kas['tanggal'])) ?></td>
                                        <td>Rp <?= number_format($kas['jumlah'], 0, ',', '.') ?></td>
                                        <td><?= esc($kas['kategori']) ?></td>
                                        <td><?= esc($kas['keterangan']) ?></td>
                                        <td><?= esc($kas['nama_user']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('bendahara/kas-keluar/edit/' . $kas['id_kas_keluar']) ?>"
                                                    class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-delete-url="<?= base_url('bendahara/kas-keluar/delete/' . $kas['id_kas_keluar']) ?>"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
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
        text-align: center;
        margin-bottom: 1rem;
    }

    .dt-buttons .btn {
        margin: 0 5px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const deleteUrl = button.getAttribute('data-delete-url');
                document.getElementById('deleteForm').setAttribute('action', deleteUrl);
            });
        }
    });
    $(document).ready(function () {
        $('#kasKeluarTable').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12'B>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Salin', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'print', text: '<i class="fas fa-print"></i> Cetak', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } }
            ],
            language: { url: "https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json" }
        });
    });
</script>
<?= $this->endSection() ?>