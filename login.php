
<?php
// login.php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pelanggaran Siswa</title>

    <!-- Bootstrap 5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f0fe, #f5f7fb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .login-icon {
            width: 75px;
            height: 75px;
            background: #e8f0fe;
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 18px;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
        }

        .btn-login {
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .login-footer {
            color: #6c757d;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="container px-3">

        <div class="login-card mx-auto">

            <!-- Logo / Icon -->
            <div class="login-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <!-- Judul -->
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-2">Pelanggaran Siswa</h4>
                <p class="text-secondary mb-0">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            <!-- Pesan Error -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['pesan_error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <!-- Form Login -->
            <form action="proses_login.php" method="POST">

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        Email
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="Masukkan email"
                            autocomplete="username"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">
                        Password
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required>

                        <button
                            class="btn btn-outline-secondary"
                            type="button"
                            id="togglePassword"
                            aria-label="Tampilkan password">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Login
                </button>

            </form>

            <hr class="my-4">

            <div class="text-center login-footer">
                &copy; <?= date('Y') ?> Aplikasi Pelanggaran Siswa
                <br>
                Sistem Informasi Sekolah
            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tampilkan / Sembunyikan Password -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    </script>

</body>
</html>
