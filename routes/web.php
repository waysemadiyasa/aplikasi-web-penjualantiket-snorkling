
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\Admin\SettingController;


// PUBLIC WEBSITE
Route::get('/', [HomeController::class, 'index'])
    ->name('home');
Route::get('/wisata/{slug}', [HomeController::class, 'category'])
    ->name('packages.category');

Route::get('/paket/{slug}', [HomeController::class, 'show'])
    ->name('packages.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// CUSTOMER BOOKING - WAJIB LOGIN
Route::middleware('auth')->group(function () {

    Route::get('/booking/{scheduleId}', [
        PublicBookingController::class,
        'create'
    ])->name('booking.create');

    Route::post('/booking', [
        PublicBookingController::class,
        'store'
    ])->name('booking.store');

    });

Route::get('/booking/success/{bookingCode}', [
    PublicBookingController::class,
    'success'
])->name('booking.success');
// PUBLIC PAYMENT PROOF UPLOAD
Route::post('/booking/{bookingCode}/upload-proof', [
    PublicBookingController::class,
    'uploadProof'
])->name('booking.upload-proof');
// PUBLIC BOOKING TRACKING
Route::get('/cek-booking', [
    PublicBookingController::class,
    'tracking'
])->name('booking.tracking');

Route::post('/cek-booking', [
    PublicBookingController::class,
    'checkTracking'
])->name('booking.tracking.check');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


});
// ADMIN ROUTES
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('packages', PackageController::class);

        Route::resource('schedules', ScheduleController::class);

        Route::get('/bookings', [BookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/create', [BookingController::class, 'create'])
            ->name('bookings.create');

        Route::post('/bookings', [BookingController::class, 'store'])
            ->name('bookings.store');

        Route::get('/bookings/{booking}', [BookingController::class, 'show'])
            ->name('bookings.show');

        Route::patch('/bookings/{booking}/status', [
            BookingController::class,
            'updateStatus'
        ])->name('bookings.status');
        Route::resource('payments', PaymentController::class)
            ->only(['index', 'show']);
        Route::get('/payments/{payment}/proof', [
            PaymentController::class,'showProof'])
            ->name('payments.proof');

        Route::patch('/payments/{payment}/status', [
             PaymentController::class,
            'updateStatus'
        ])->name('payments.status');
        Route::get('/customers', [CustomerController::class, 'index'])
            ->name('customers.index');

        Route::get('/customers/detail', [CustomerController::class, 'show'])
             ->name('customers.show');
        // SETTINGS
        Route::get('/settings', [SettingController::class, 'index'])
             ->name('settings.index');

        Route::put('/settings', [SettingController::class, 'update'])
              ->name('settings.update');  
    });
    

require __DIR__.'/auth.php';
