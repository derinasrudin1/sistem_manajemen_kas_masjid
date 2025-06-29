<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transparansi Keuangan Masjid</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Laporan</th>
                                    <th>Masjid</th>
                                    <th>Periode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($laporan as $lap) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($lap['judul']) ?></td>
                                        <td><?= esc($lap['nama_masjid']) ?></td>
                                        <td>
                                            <?= date('d M Y', strtotime($lap['periode_awal'])) ?> - 
                                            <?= date('d M Y', strtotime($lap['periode_akhir'])) ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('/laporan/' . $lap['id_laporan']) ?>" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
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