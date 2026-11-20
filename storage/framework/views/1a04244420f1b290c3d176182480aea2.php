


<?php $__env->startSection('title', $category->name . ' - KAI TRIP TOMORROW'); ?>

<?php $__env->startSection('content'); ?>

<!-- HEADER KATEGORI -->
<section class="section-padding" style="background: linear-gradient(135deg, #07334a, #087e9c);">
    <div class="container text-center text-white py-4">

        <span class="text-uppercase fw-semibold">
            KAI TRIP TOMORROW
        </span>

        <h1 class="fw-bold mt-3">
            WISATA <?php echo e($category->name); ?>

        </h1>

        <p class="text-white-50 mt-3 mb-0">
            Temukan pilihan paket <?php echo e(strtolower($category->name)); ?>

            terbaik untuk pengalaman wisata di Nusa Penida.
        </p>

    </div>
</section>

<!-- DAFTAR PAKET -->
<section class="section-padding">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <span class="category-label">OUR PACKAGES</span>
                <h2 class="section-title mt-2">
                    WISATA <?php echo e($category->name); ?>

                </h2>
            </div>

            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali ke Beranda
            </a>

        </div>

        <div class="row g-4">

            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="col-md-6 col-lg-4">

                    <div class="package-card h-100">

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
                                <?php echo e($category->name); ?>

                            </span>

                            <h3 class="package-name">
                                <?php echo e($package->name); ?>

                            </h3>

                            <p class="package-description">
                                <?php echo e(\Illuminate\Support\Str::limit($package->description ?? 'Nikmati pengalaman wisata bersama KAI TRIP TOMORROW.', 95)); ?>

                            </p>

                            <?php if($package->duration): ?>
                                <div class="text-secondary small mb-3">
                                    <i class="bi bi-clock me-1"></i>
                                    <?php echo e($package->duration); ?>

                                </div>
                            <?php endif; ?>

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

                    <h4 class="mt-3">
                        Paket <?php echo e($category->name); ?> Belum Tersedia
                    </h4>

                    <p class="text-secondary">
                        Silakan kembali lagi untuk melihat pilihan paket wisata kami.
                    </p>

                    <a href="<?php echo e(route('home')); ?>" class="btn btn-main mt-2">
                        Kembali ke Beranda
                    </a>

                </div>

            <?php endif; ?>

        </div>

        <?php if($packages->hasPages()): ?>
            <div class="mt-5 d-flex justify-content-center">
                <?php echo e($packages->links()); ?>

            </div>
        <?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\kaitravel\resources\views/public/package-category.blade.php ENDPATH**/ ?>