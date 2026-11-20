


<?php $__env->startSection('title', 'KAI TRIP TOMORROW - Wisata Snorkeling dan Speedboat Nusa Penida'); ?>

<?php $__env->startSection('content'); ?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="container">
        <div class="hero-content">

            <span class="hero-label">
                <i class="bi bi-stars me-2"></i>
                Explore The Beauty of Nusa Penida
            </span>

            <h1>
                Discover The Ocean,
                Create Your Adventure.
            </h1>

            <p>
                Nikmati pengalaman snorkeling dan perjalanan speedboat
                yang menyenangkan bersama KAI TRIP TOMORROW.
                Jelajahi keindahan laut Nusa Penida bersama kami.
            </p>

            <a href="#paket" class="btn btn-main btn-lg">
                Jelajahi Paket Wisata
                <i class="bi bi-arrow-right ms-2"></i>
            </a>

        </div>
    </div>
</section>


<!-- STATISTIK -->
<section class="py-4 bg-white">
    <div class="container">
        <div class="row text-center g-3">

            <div class="col-6 col-md-6">
                <h3 class="fw-bold text-info mb-1">
                    <?php echo e($totalPackages); ?>+
                </h3>
                <span class="text-secondary">Pilihan Paket Wisata</span>
            </div>

            <div class="col-6 col-md-6">
                <h3 class="fw-bold text-info mb-1">
                    <?php echo e($totalSchedules); ?>+
                </h3>
                <span class="text-secondary">Jadwal Tersedia</span>
            </div>

        </div>
    </div>
</section>


<!-- PAKET WISATA -->
<section class="section-padding" id="paket">
    <div class="container">

        <div class="text-center mb-5">
            <span class="category-label">OUR PACKAGES</span>

            <h2 class="section-title mt-3">
                Pilihan Paket Wisata
            </h2>

            <p class="section-subtitle">
                Pilih pengalaman wisata laut terbaik sesuai kebutuhan
                perjalananmu bersama KAI TRIP TOMORROW.
            </p>
        </div>

        <div class="row g-4">

            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="col-md-6 col-lg-4">

                    <div class="package-card">

                        <?php if($package->image): ?>
                            <img
                                src="<?php echo e(asset('storage/' . $package->image)); ?>"
                                class="package-image"
                                alt="<?php echo e($package->name); ?>"
                            >
                        <?php else: ?>
                            <div class="package-image-placeholder">
                                <i class="bi bi-water"></i>
                            </div>
                        <?php endif; ?>

                        <div class="package-body">

                            <span class="category-label">
                                <?php echo e($package->category?->name ?? 'Wisata'); ?>

                            </span>

                            <h3 class="package-name">
                                <?php echo e($package->name); ?>

                            </h3>

                            <p class="package-description">
                                <?php echo e(\Illuminate\Support\Str::limit($package->description ?? 'Nikmati pengalaman wisata bersama KAI TRAVEL.', 95)); ?>

                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-4">

                                <div>
                                    <small class="text-secondary">Mulai dari</small>

                                    <div class="package-price">
                                        Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?>

                                    </div>
                                </div>

                                <a href="<?php echo e(route('packages.show', $package->slug)); ?>"
                                   class="btn btn-main">
                                    Detail
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="col-12 text-center py-5">

                    <i class="bi bi-compass display-3 text-secondary"></i>

                    <h4 class="mt-3">Paket Wisata Belum Tersedia</h4>

                    <p class="text-secondary">
                        Silakan kembali lagi untuk melihat pilihan paket wisata kami.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>
</section>


<!-- TENTANG KAMI -->
<section class="feature-section section-padding" id="tentang">
    <div class="container">

        <div class="text-center mb-5">
            <span class="category-label">WHY CHOOSE US</span>

            <h2 class="text-white fw-bold mt-3">
                Mengapa Memilih KAI TRIP TOMORROW?
            </h2>

            <p class="text-white-50 mt-3">
                Kami ingin memberikan pengalaman perjalanan yang nyaman,
                aman, dan berkesan.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bi bi-water"></i>
                    </div>

                    <h5>Wisata Menarik</h5>

                    <p>
                        Jelajahi keindahan bawah laut dan destinasi
                        terbaik di Nusa Penida.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <h5>Pelayanan Terpercaya</h5>

                    <p>
                        Kami berkomitmen memberikan pelayanan
                        terbaik selama perjalanan wisata.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <h5>Booking Mudah</h5>

                    <p>
                        Pilih paket dan jadwal perjalanan
                        dengan proses pemesanan yang praktis.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\kaitravel\resources\views/public/home.blade.php ENDPATH**/ ?>