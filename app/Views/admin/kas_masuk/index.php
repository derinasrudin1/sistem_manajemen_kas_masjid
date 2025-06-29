<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Kas Masuk<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Kas Masuk</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kas Masuk</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/kas-masuk/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-md-4">
                <form action="<?= base_url('admin/kas-masuk') ?>" method="GET">
                    <div class="input-group">
                        <select name="id_masjid" class="form-control">
                            <option value="">Semua Masjid</option>
                            <?php foreach ($masjids as $masjid): ?>
                                <option value="<?= $masjid['id_masjid'] ?>" <?= isset($_GET['id_masjid']) && $_GET['id_masjid'] == $masjid['id_masjid'] ? 'selected' : '' ?>>
                                    <?= esc($masjid['nama_masjid']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Masjid</th>
                    <th>Jumlah</th>
                    <th>Sumber Dana</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kasMasuk as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td><?= esc($item['nama_masjid'] ?? '-') ?></td>
                        <td class="text-right">Rp <?= number_format($item['jumlah'], 0, ',', '.') ?></td>
                        <td><?= esc($item['sumber']) ?></td>
                        <td><?= esc($item['keterangan'] ?? '-') ?></td>
                        <td>
                            <a href="<?= base_url("admin/kas-masuk/edit/{$item['id_kas_masuk']}") ?>"
                                class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= base_url("admin/kas-masuk/delete/{$item['id_kas_masuk']}") ?>" method="POST"
                                class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin?')">
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[1, 'desc']],
            dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7]
                    }
                }
            ],
            columnDefs: [
                {
                    targets: [6, 8],
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
<?= $this->endSection() ?>