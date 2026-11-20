
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $__env->yieldContent('title', 'KAI TRIP TOMORROW - Explore Nusa Penida'); ?></title>

    <meta name="description" content="Jelajahi keindahan Nusa Penida bersama KAI TRIP TOMORROW. Pilihan paket snorkeling dan speedboat dengan pelayanan terbaik.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }

        body {
            background: #f7fafc;
            color: #183247;
        }

        .navbar {
            background: #ffffff;
            padding: 17px 0;
            box-shadow: 0 3px 18px rgba(0,0,0,.05);
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: 800;
            color: #073b56 !important;
            letter-spacing: -.8px;
        }

        .brand-icon {
            color: #08a6a6;
        }

        .nav-link {
            font-weight: 600;
            color: #38546a !important;
            margin: 0 8px;
        }

        .btn-main {
            background: #079eaa;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 25px;
            font-weight: 700;
        }

        .btn-main:hover {
            background: #067d89;
            color: white;
        }

        .hero {
            min-height: 570px;
            display: flex;
            align-items: center;
            color: white;
            background:
                linear-gradient(90deg, rgba(3,35,54,.88), rgba(3,35,54,.35)),
                url('https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=2000&q=85');
            background-position: center;
            background-size: cover;
        }

        .hero-content {
            max-width: 680px;
            padding: 90px 0;
        }

        .hero-label {
            display: inline-block;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 30px;
            padding: 9px 17px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(38px, 6vw, 64px);
            font-weight: 800;
            line-height: 1.12;
            margin-bottom: 22px;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.8;
            color: #e3f1f5;
            margin-bottom: 30px;
        }

        .section-padding {
            padding: 85px 0;
        }

        .section-title {
            font-size: 34px;
            font-weight: 800;
            color: #073b56;
        }

        .section-subtitle {
            color: #718397;
            max-width: 600px;
            margin: 12px auto 0;
        }

        .package-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #edf1f4;
            box-shadow: 0 8px 30px rgba(20,55,75,.06);
            height: 100%;
            transition: .3s;
        }

        .package-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 35px rgba(20,55,75,.12);
        }

        .package-image {
            height: 220px;
            width: 100%;
            object-fit: cover;
        }

        .package-image-placeholder {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 55px;
            background: linear-gradient(135deg, #087c9b, #12b9b0);
        }

        .package-body {
            padding: 23px;
        }

        .category-label {
            display: inline-block;
            color: #078b99;
            background: #e5f7f7;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .package-name {
            font-size: 20px;
            font-weight: 800;
            color: #123c54;
            margin: 14px 0 9px;
        }

        .package-description {
            font-size: 14px;
            color: #718397;
            min-height: 45px;
        }

        .package-price {
            color: #079eaa;
            font-size: 22px;
            font-weight: 800;
        }

        .feature-section {
            background: #073b56;
            color: white;
        }

        .feature-icon {
            font-size: 34px;
            color: #42d4cf;
            margin-bottom: 18px;
        }

        .feature-item h5 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-item p {
            color: #c4dce5;
            font-size: 14px;
        }

        footer {
            background: #052b40;
            color: #d4e4eb;
            padding: 45px 0 20px;
        }

        footer h4 {
            color: white;
            font-weight: 800;
        }

        footer a {
            color: #d4e4eb;
            text-decoration: none;
        }

        footer a:hover {
            color: #42d4cf;
        }
/* MOBILE IMPROVEMENTS */
.package-card {
    display: flex;
    flex-direction: column;
}

.package-body {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.package-body .d-flex {
    margin-top: auto !important;
}

.package-image {
    display: block;
}

.btn-main {
    transition: all .25s ease;
}

.btn-main:hover {
    transform: translateY(-2px);
}

.navbar-brand img {
    flex-shrink: 0;
}

html {
    scroll-behavior: smooth;
}

@media(max-width: 768px) {

    .navbar {
        padding: 12px 0;
    }

    .navbar-brand {
        font-size: 19px;
        letter-spacing: -.4px;
    }

    .hero {
        min-height: 480px;
        text-align: center;
        background-position: center;
    }

    .hero-content {
        padding: 65px 10px;
    }

    .hero h1 {
        font-size: clamp(32px, 8vw, 43px);
    }

    .hero p {
        font-size: 15px;
        line-height: 1.7;
    }

    .hero-label {
        font-size: 11px;
    }

    .btn-main {
        padding: 11px 20px;
        font-size: 14px;
    }

    .package-image,
    .package-image-placeholder {
        height: 200px;
    }

    .package-body {
        padding: 19px;
    }

    .package-name {
        font-size: 18px;
    }

    .package-price {
        font-size: 19px;
    }

    .section-title {
        font-size: 27px;
    }

    .section-padding {
        padding: 55px 0;
    }

    footer {
        padding: 35px 0 20px;
    }
}

        @media(max-width: 768px) {
            .hero {
                min-height: 510px;
            }

            .hero-content {
                padding: 70px 0;
            }

            .section-padding {
                padding: 60px 0;
            }

            .section-title {
                font-size: 28px;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('home')); ?>">

    <?php if(isset($setting) && $setting->logo): ?>
        <img src="<?php echo e(asset('storage/' . $setting->logo)); ?>"
             alt="Logo"
             style="height:45px; max-width:100px; object-fit:contain;">
    <?php else: ?>
        <i class="bi bi-water brand-icon"></i>
    <?php endif; ?>

    <span>
        <?php echo e($setting->business_name ?? 'KAI TRIP TOMORROW'); ?>

    </span>

	</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('booking.tracking')); ?>">
                   <i class="bi bi-search me-1"></i>
                          Cek Booking
                </a>
                    </li>
                <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
            href="#"
            id="wisataDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">
                Tiket Wisata
            </a>

            <ul class="dropdown-menu" aria-labelledby="wisataDropdown">

                <li>
                    <a class="dropdown-item"
                    href="<?php echo e(route('packages.category', 'snorkeling')); ?>">
                        <i class="bi bi-water me-2"></i>
                        Tiket Snorkeling
                    </a>
                </li>

                <li>
                    <a class="dropdown-item"
                    href="<?php echo e(route('packages.category', 'speed-boat')); ?>">
                        <i class="bi bi-tsunami me-2"></i>
                        Tiket Speedboat
                    </a>
                </li>

             </ul>
                    </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>#tentang">Tentang Kami</a>
                </li>

                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">
                            <i class="bi bi-person-circle me-1"></i>
                            Login
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo e(Auth::user()->name); ?>

                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="nav-link border-0 bg-transparent">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                <?php endif; ?>


                <li class="nav-item ms-lg-3">
                    <a href="<?php echo e(route('home')); ?>#paket" class="btn btn-main">
                        Booking Sekarang
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer>
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">

    <h4 class="d-flex align-items-center gap-2">
        <?php if(isset($setting) && $setting->logo): ?>
            <img src="<?php echo e(asset('storage/' . $setting->logo)); ?>"
                 alt="Logo"
                 style="height:40px; max-width:90px; object-fit:contain;">
        <?php else: ?>
            <i class="bi bi-water"></i>
        <?php endif; ?>

        <?php echo e($setting->business_name ?? 'KAI TRIP TOMORROW'); ?>

    </h4>

    <p class="mt-3">
        <?php echo e($setting->business_description ?? 'Temukan pengalaman wisata laut terbaik bersama kami.'); ?>

    </p>

	</div>

            <div class="col-md-3">
                <h5 class="text-white fw-bold">Navigasi</h5>
                <p><a href="<?php echo e(route('home')); ?>">Home</a></p>
                <p><a href="<?php echo e(route('home')); ?>#paket">Paket Wisata</a></p>
                <p><a href="<?php echo e(route('home')); ?>#tentang">Tentang Kami</a></p>
            </div>

            <div class="col-md-3">
    <h5 class="text-white fw-bold">Informasi</h5>

    <?php if(!empty($setting?->business_address)): ?>
        <p>
            <i class="bi bi-geo-alt me-2"></i>
            <?php echo e($setting->business_address); ?>

        </p>
    <?php endif; ?>

    <?php if(!empty($setting?->whatsapp)): ?>
        <p>
            <i class="bi bi-whatsapp me-2"></i>
            <a href="https://wa.me/<?php echo e(preg_replace('/\D/', '', $setting->whatsapp)); ?>"
               target="_blank">
                <?php echo e($setting->whatsapp); ?>

            </a>
        </p>
    <?php endif; ?>

    <?php if(!empty($setting?->email)): ?>
        <p>
            <i class="bi bi-envelope me-2"></i>
            <a href="mailto:<?php echo e($setting->email); ?>">
                <?php echo e($setting->email); ?>

            </a>
        </p>
    <?php endif; ?>

    <?php if(!empty($setting?->instagram)): ?>
        <p>
            <i class="bi bi-instagram me-2"></i>
            <a href="<?php echo e($setting->instagram); ?>" target="_blank">Instagram</a>
        </p>
    <?php endif; ?>

    <?php if(!empty($setting?->facebook)): ?>
        <p>
            <i class="bi bi-facebook me-2"></i>
            <a href="<?php echo e($setting->facebook); ?>" target="_blank">Facebook</a>
        </p>
    <?php endif; ?>

    <p>
        <i class="bi bi-water me-2"></i>
        Snorkeling & Speedboat
    </p>
</div>

        </div>

        <hr class="border-secondary mt-4">

        <div class="text-center small">
    &copy; <?php echo e(date('Y')); ?>

    <?php echo e($setting->business_name ?? 'KAI TRIP TOMORROW'); ?>.
    All Rights Reserved.
</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\kaitravel\resources\views/public/layouts/app.blade.php ENDPATH**/ ?>