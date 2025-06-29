<?= $this->extend('layouts/main') ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kas Keluar</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('/admin/kas-keluar/create'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                        <a href="<?= base_url('/admin/kas-keluar/export'); ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Masjid</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
                                    <th>Keterangan</th>
                                    <th>Input Oleh</th>

                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kasKeluar as $kk): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= date('d-m-Y', strtotime($kk['tanggal'])); ?></td>
                                        <td><?= $kk['nama_masjid'] ?? '-'; ?></td>
                                        <td class="text-right"><?= number_format($kk['jumlah'], 0, ',', '.'); ?></td>
                                        <td><?= $kk['kategori']; ?></td>
                                        <td><?= $kk['keterangan'] ?? '-'; ?></td>
                                        <td><?= $kk['nama_user'] ?? '-'; ?></td>

                                        <td class="text-center">
                                            <a href="<?= base_url('/admin/kas-keluar/edit/' . $kk['id_kas_keluar']); ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('/admin/kas-keluar/' . $kk['id_kas_keluar']); ?>"
                                                method="POST" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah anda yakin?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[1, 'desc']]
        });
    });
</script>
<?= $this->endSection(); ?>