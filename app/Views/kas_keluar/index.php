<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kas Keluar
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
<li class="breadcrumb-item active">Kas Keluar</li>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header bg-danger text-white">
        <h1 class="card-title h4 mb-0">Data Kas Keluar</h1>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Kas Masuk</h5>
                        <p class="card-text fs-5">Rp <?= number_format($total_masuk, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Total Kas Keluar</h5>
                        <p class="card-text fs-5">Rp <?= number_format($total_keluar, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Sisa Saldo</h5>
                        <p class="card-text fs-5">Rp <?= number_format($sisa_saldo, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <a href="<?= base_url('kaskeluar/create') ?>" class="btn btn-danger">
                <i class="bi bi-plus-circle-fill"></i> Tambah Kas Keluar
            </a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kas_keluar)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data kas keluar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($kas_keluar as $i => $kas): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= date('d M Y', strtotime($kas['tanggal'])) ?></td>
                                <td>Rp <?= number_format($kas['jumlah'], 0, ',', '.') ?></td>
                                <td><?= esc($kas['kategori']) ?></td>
                                <td><?= esc($kas['keterangan']) ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('kaskeluar/edit/' . $kas['id_kas_keluar']) ?>"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-delete-url="<?= base_url('kaskeluar/delete/' . $kas['id_kas_keluar']) ?>">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini? Proses ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script JS untuk Modal Delete -->
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const deleteUrl = button.getAttribute('data-delete-url');
        const form = document.getElementById('deleteForm');
        form.setAttribute('action', deleteUrl);
    });
</script>
<?= $this->endSection() ?>