


<?php $__env->startSection('title', $package->name . ' - KAI TRAVEL'); ?>

<?php $__env->startSection('content'); ?>

<!-- BREADCRUMB -->
<section class="py-3 bg-white border-bottom">
    <div class="container">
        <a href="<?php echo e(route('home')); ?>" class="text-decoration-none text-secondary">
            <i class="bi bi-house"></i> Home
        </a>

        <i class="bi bi-chevron-right mx-2 small"></i>

        <span class="text-dark fw-semibold">
            <?php echo e($package->name); ?>

        </span>
    </div>
</section>

<!-- DETAIL PAKET -->
<section class="section-padding">
    <div class="container">

        <div class="row g-5">

            <!-- FOTO PAKET -->
            <div class="col-lg-6">

                <?php if($package->image): ?>
                    <img
                        src="<?php echo e(asset('storage/' . $package->image)); ?>"
                        alt="<?php echo e($package->name); ?>"
                        class="w-100 rounded-4 shadow-sm"
                        style="height: 420px; object-fit: cover;"
                    >
                <?php else: ?>
                    <div class="package-image-placeholder rounded-4"
                         style="height: 420px;">
                        <i class="bi bi-water"></i>
                    </div>
                <?php endif; ?>

            </div>

            <!-- INFORMASI PAKET -->
            <div class="col-lg-6">

                <span class="category-label">
                    <?php echo e($package->category?->name ?? 'Wisata'); ?>

                </span>

                <h1 class="fw-bold mt-3 mb-3"
                    style="color:#073b56;">
                    <?php echo e($package->name); ?>

                </h1>

                <p class="text-secondary" style="line-height:1.9;">
                    <?php echo e($package->description ?? 'Nikmati pengalaman wisata bersama KAI TRAVEL.'); ?>

                </p>

                <div class="bg-white rounded-4 p-4 shadow-sm mt-4">

                    <small class="text-secondary">
                        Harga paket mulai dari
                    </small>

                    <h2 class="package-price mt-1">
                        Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?>

                    </h2>

                    <hr>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-geo-alt text-info fs-5 me-3"></i>
                        <span>Nusa Penida, Bali</span>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check text-info fs-5 me-3"></i>
                        <span>Jadwal keberangkatan tersedia di bawah</span>
                    </div>

                </div>

                <a href="#jadwal" class="btn btn-main btn-lg mt-4">
                    Lihat Jadwal
                    <i class="bi bi-arrow-down ms-2"></i>
                </a>

            </div>

        </div>

        <!-- FASILITAS -->
        <?php if($package->facilities): ?>
            <div class="mt-5">

                <h3 class="fw-bold mb-3" style="color:#073b56;">
                    <i class="bi bi-check-circle text-info me-2"></i>
                    Fasilitas Paket
                </h3>

                <div class="bg-white rounded-4 shadow-sm p-4">
                    <?php echo nl2br(e($package->facilities)); ?>

                </div>

            </div>
        <?php endif; ?>

    </div>
</section>

<!-- JADWAL -->
<section class="section-padding bg-white" id="jadwal">
    <div class="container">

        <div class="text-center mb-5">
            <span class="category-label">AVAILABLE SCHEDULES</span>

            <h2 class="section-title mt-3">
                Jadwal Keberangkatan
            </h2>

            <p class="section-subtitle">
                Pilih tanggal dan jam keberangkatan yang sesuai
                dengan rencana perjalananmu.
            </p>
        </div>

        <div class="row g-4">

            <?php $__empty_1 = true; $__currentLoopData = $package->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="col-md-6 col-lg-4">

                    <div class="package-card p-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="category-label">
                                Tersedia
                            </span>

                            <i class="bi bi-calendar2-week fs-4 text-info"></i>

                        </div>

                        <h5 class="fw-bold">
                            <?php echo e($schedule->travel_date->format('d F Y')); ?>

                        </h5>

                        <p class="text-secondary mb-2">
                            <i class="bi bi-clock me-2"></i>
                            <?php echo e(\Carbon\Carbon::parse($schedule->departure_time)->format('H:i')); ?>

                            WITA
                        </p>

                        <p class="text-secondary mb-3">
                            <i class="bi bi-people me-2"></i>
                            <?php echo e($schedule->available_seats); ?> kursi tersedia
                        </p>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <small class="text-secondary">Harga per orang</small>

                                <div class="fw-bold text-info">
                                    Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?>

                                </div>
                            </div>

                            <a href="<?php echo e(route('booking.create', $schedule->id)); ?>"
                                class="btn btn-main">
                                   Pilih Jadwal
                                 <i class="bi bi-arrow-right ms-1"></i>
                                </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="col-12 text-center py-5">

                    <i class="bi bi-calendar-x display-3 text-secondary"></i>

                    <h4 class="mt-3">
                        Jadwal Belum Tersedia
                    </h4>

                    <p class="text-secondary">
                        Silakan hubungi kami untuk informasi jadwal berikutnya.
                    </p>

                </div>

            <?php endif; ?>

        </div>

        <div class="text-center mt-5">
            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali ke Homepage
            </a>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\kaitravel\resources\views/public/package-detail.blade.php ENDPATH**/ ?>