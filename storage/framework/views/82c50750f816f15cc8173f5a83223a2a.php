<?php $__env->startSection('title', 'Login Customer - KAI TRIP TOMORROW'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .auth-section {
        min-height: 650px;
        padding: 75px 15px;
        background: linear-gradient(135deg, #e8f7f8, #f7fafc);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-card {
        width: 100%;
        max-width: 460px;
        background: white;
        padding: 40px;
        border-radius: 22px;
        box-shadow: 0 15px 45px rgba(7, 59, 86, .10);
    }

    .auth-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 20px;
        background: #e5f7f7;
        color: #079eaa;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .auth-title {
        color: #073b56;
        font-weight: 800;
    }

    .auth-subtitle {
        color: #718397;
        font-size: 14px;
    }

    .auth-input {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #dce5eb;
    }

    .auth-input:focus {
        border-color: #079eaa;
        box-shadow: 0 0 0 .2rem rgba(7, 158, 170, .12);
    }

    .auth-button {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 30px;
        background: #079eaa;
        color: white;
        font-weight: 700;
    }

    .auth-button:hover {
        background: #067d89;
        color: white;
    }

    .auth-link {
        color: #079eaa;
        font-weight: 700;
        text-decoration: none;
    }

    @media(max-width: 576px) {
        .auth-card {
            padding: 28px 22px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<section class="auth-section">
    <div class="auth-card">

        <div class="text-center mb-4">
            <div class="auth-icon">
                <i class="bi bi-person-circle"></i>
            </div>

            <h2 class="auth-title">Selamat Datang!</h2>

            <p class="auth-subtitle">
                Login untuk melanjutkan perjalanan wisata bersama KAI TRIP TOMORROW.
            </p>
        </div>

        <?php if(session('status')): ?>
            <div class="alert alert-success">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                Email atau password tidak valid. Silakan periksa kembali.
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo e(old('email')); ?>"
                    class="form-control auth-input"
                    placeholder="Masukkan email Anda"
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control auth-input"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="form-check-input"
                    >
                    <label for="remember" class="form-check-label small">
                        Ingat saya
                    </label>
                </div>

                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>"
                       class="auth-link small">
                        Lupa password?
                    </a>
                <?php endif; ?>
            </div>

            <button type="submit" class="auth-button">
                LOGIN SEKARANG
                <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="small text-muted mb-0">
                Belum punya akun?

                <a href="<?php echo e(route('register')); ?>" class="auth-link">
                    Daftar Sekarang
                </a>
            </p>
        </div>

        <div class="text-center mt-3">
            <a href="<?php echo e(route('home')); ?>"
               class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\kaitravel\resources\views/auth/login.blade.php ENDPATH**/ ?>