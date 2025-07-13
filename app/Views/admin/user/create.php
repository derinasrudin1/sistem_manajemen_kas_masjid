<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Manajemen User</a></li>
<li class="breadcrumb-item active">Tambah Baru</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah User</h3>
    </div>
    <form method="POST" action="<?= base_url('admin/users/store') ?>">
        <div class="card-body">
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>"
                    required>
                <small class="text-muted">Minimal 5 karakter</small>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="text-muted">Minimal 6 karakter</small>
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role ?>" <?= old('role') == $role ? 'selected' : '' ?>>
                            <?= strtoupper($role) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" id="masjid-form-group" style="display: none;">
                <label for="id_masjid">Pilih Masjid</label>
                <select class="form-control" id="id_masjid" name="id_masjid">
                    <option value="">-- Tidak Ditugaskan --</option>
                    <?php foreach ($masjids as $masjid): ?>
                        <option value="<?= $masjid['id_masjid'] ?>" <?= old('id_masjid') == $masjid['id_masjid'] ? 'selected' : '' ?>>
                            <?= esc($masjid['nama_masjid']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Tugaskan user ini ke masjid tertentu (wajib untuk Bendahara).</small>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script>
    // menampilkan/menyembunyikan dropdown masjid berdasarkan role
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const masjidFormGroup = document.getElementById('masjid-form-group');

        function toggleMasjidSelect() {
            // Tampilkan dropdown masjid jika role BUKAN 'admin'
            if (roleSelect.value !== 'admin') {
                masjidFormGroup.style.display = 'block';
                document.getElementById('id_masjid').setAttribute('required', 'required');
            } else {
                masjidFormGroup.style.display = 'none';
                document.getElementById('id_masjid').removeAttribute('required');
            }
        }

        // Jalankan fungsi saat halaman pertama kali dimuat
        toggleMasjidSelect();

        // Jalankan fungsi setiap kali nilai role berubah
        roleSelect.addEventListener('change', toggleMasjidSelect);
    });
</script>
<?= $this->endSection() ?>