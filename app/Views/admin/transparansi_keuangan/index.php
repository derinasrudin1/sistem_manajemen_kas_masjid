<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transparansi Keuangan Masjid</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('/admin/transparansi-keuangan/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Laporan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Laporan</th>
                                    <th>Masjid</th>
                                    <th>Periode</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Saldo</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
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
                                        <td class="text-right text-success">
                                            Rp <?= number_format($lap['total_pemasukan'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-right text-danger">
                                            Rp <?= number_format($lap['total_pengeluaran'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-right">
                                            Rp <?= number_format($lap['saldo_akhir'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($lap['status'] === 'published') : ?>
                                                <span class="badge badge-success">Publik</span>
                                            <?php else : ?>
                                                <span class="badge badge-secondary">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($lap['status'] === 'published') : ?>
                                                <a href="<?= base_url('/admin/transparansi-keuangan/unpublish/' . $lap['id_laporan']) ?>" 
                                                   class="btn btn-sm btn-warning" title="Batalkan Publikasi">
                                                    <i class="fas fa-eye-slash"></i>
                                                </a>
                                            <?php else : ?>
                                                <a href="<?= base_url('/admin/transparansi-keuangan/publish/' . $lap['id_laporan']) ?>" 
                                                   class="btn btn-sm btn-info" title="Publikasikan">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('/laporan/' . $lap['id_laporan']) ?>" 
                                               class="btn btn-sm btn-success" title="Lihat" target="_blank">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            <form action="<?= base_url('/admin/transparansi-keuangan/delete/' . $lap['id_laporan']) ?>" 
                                                  method="POST" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Hapus" onclick="return confirm('Apakah anda yakin?')">
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
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[3, 'desc']],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data per halaman',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: '&raquo;',
                    previous: '&laquo;'
                }
            }
        });
    });
</script>
<?= $this->endSection(); ?>