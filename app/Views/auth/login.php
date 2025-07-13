<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <style>
        body.login-page {
            background-color: #f4f6f9;
        }

        .login-box {
            width: 540px;
        }

        .login-card-body .login-logo-in-card {
            text-align: center;
            margin-bottom: 2px;
        }

        .login-card-body .login-logo-in-card img {
            width: 500px;
            max-width: 100%;
            height: auto;
        }

        .login-card-body .login-app-name {
            text-align: center;
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

        .login-box-msg {
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .login-box {
                width: 90%;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-body login-card-body">

                <div class="login-logo-in-card">
                    <img src="<?= base_url('logo.png') ?>" alt="Logo Aplikasi">
                </div>

                <p class="login-box-msg">Login ke Sistem</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert" id="error-alert">
                        <?= session()->getFlashdata('error') ?>
                        <!-- Placeholder untuk countdown akan ditambahkan oleh JavaScript -->
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/auth/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil waktu akhir penguncian dari PHP (dalam detik)
            const lockoutEndTime = <?= $lockout_time ?? 0 ?>;
            const now = Math.floor(Date.now() / 1000); // Waktu saat ini dalam detik

            // Cek apakah waktu penguncian masih aktif
            if (lockoutEndTime > now) {
                const loginButton = document.getElementById('loginButton');
                const errorAlert = document.getElementById('error-alert');

                // Buat elemen baru untuk menampilkan countdown
                const countdownElement = document.createElement('div');
                countdownElement.className = 'mt-2';
                if (errorAlert) {
                    errorAlert.appendChild(countdownElement);
                }

                // Matikan tombol login
                loginButton.disabled = true;
                loginButton.innerText = 'Tunggu...';

                // Fungsi untuk memperbarui timer setiap detik
                const timer = setInterval(function () {
                    const currentTime = Math.floor(Date.now() / 1000);
                    const remainingSeconds = lockoutEndTime - currentTime;

                    if (remainingSeconds > 0) {
                        // Tampilkan sisa waktu
                        countdownElement.innerHTML = `<strong>Silakan coba lagi dalam ${remainingSeconds} detik.</strong>`;
                    } else {
                        // Jika waktu habis, hentikan timer dan aktifkan kembali tombol
                        clearInterval(timer);
                        countdownElement.innerHTML = '<strong>Anda sudah bisa mencoba login kembali.</strong>';
                        loginButton.disabled = false;
                        loginButton.innerText = 'Login';
                    }
                }, 1000); // Update setiap 1 detik
            }
        });
    </script>
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>

</html>