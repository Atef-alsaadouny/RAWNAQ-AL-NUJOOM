<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\RatingController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Customer\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSend'])->name('contact.send')->middleware('throttle:5,1');
Route::get('/track', [HomeController::class, 'track'])->name('track');
Route::post('/track', [HomeController::class, 'trackLookup'])->name('track.lookup')->middleware('throttle:30,10');
Route::get('/track/result/{appointment}', [HomeController::class, 'trackResult'])->name('track.result')->middleware('throttle:30,10');

// Public Booking (للزوار والمسجلين — بدون تسجيل)
Route::get('/book', [BookingController::class, 'create'])->name('book');
Route::post('/book', [BookingController::class, 'store'])->name('book.store')->middleware('throttle:20,10');
Route::get('/booking/{appointment}/confirmed', [BookingController::class, 'confirmed'])->name('booking.confirmed');
Route::get('/booking/{appointment}/edit', [BookingController::class, 'guestEdit'])->name('booking.guest.edit')->middleware('throttle:30,10');
Route::put('/booking/{appointment}', [BookingController::class, 'guestUpdate'])->name('booking.guest.update')->middleware('throttle:30,10');
Route::delete('/booking/{appointment}', [BookingController::class, 'guestCancel'])->name('booking.guest.cancel')->middleware('throttle:5,10');

// Public Guest Rating (للزوار — بدون تسجيل)
Route::post('/ratings/{appointment}', [RatingController::class, 'guestStore'])->name('rating.guest.store')->middleware('throttle:30,10');

// Payment Routes (عامة — يحتاجها Tap callback)
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/{appointment}/pay', [PaymentController::class, 'pay'])->name('pay');
    Route::post('/{appointment}/process', [PaymentController::class, 'process'])->name('process')->middleware('throttle:5,10');
    Route::get('/callback', [PaymentController::class, 'callback'])->name('callback')->middleware('throttle:30,10');
    Route::get('/{appointment}/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/{appointment}/cancel', [PaymentController::class, 'cancel'])->name('cancel');
});

// Customer Routes (يتطلب تسجيل الدخول)
Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer', 'throttle:100,1'])->group(function () {
    Route::get('/appointments', [CustomerController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{appointment}', [CustomerController::class, 'show'])->name('appointment.show');
    Route::get('/appointments/{appointment}/edit', [BookingController::class, 'edit'])->name('appointment.edit');
    Route::put('/appointments/{appointment}', [BookingController::class, 'update'])->name('appointment.update');
    Route::delete('/appointments/{appointment}/cancel', [BookingController::class, 'customerCancel'])->name('appointment.cancel');
    Route::post('/ratings/{appointment}', [RatingController::class, 'store'])->name('rating.store');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CustomerController::class, 'updatePassword'])->name('profile.password');
});

// Employee Routes
Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:employee', 'throttle:200,1'])->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/today', [EmployeeController::class, 'todayAppointments'])->name('dashboard.today');
    Route::get('/available', [EmployeeController::class, 'available'])->name('available');
    Route::patch('/appointments/{appointment}/claim', [EmployeeController::class, 'claim'])->name('appointment.claim');
    Route::get('/appointments', [EmployeeController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{appointment}', [EmployeeController::class, 'show'])->name('appointment.show');
    Route::patch('/appointments/{appointment}/status', [EmployeeController::class, 'updateStatus'])->name('appointment.status');
    Route::get('/ratings', [EmployeeController::class, 'ratings'])->name('ratings');
    Route::get('/notifications/recent', [EmployeeController::class, 'recentNotifications'])->name('notifications.recent');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,owner', 'throttle:200,1'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/data', [AdminController::class, 'dashboardData'])->name('dashboard.data');
    Route::resource('customers', AdminCustomerController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('employees', AdminEmployeeController::class);
    Route::get('/employees/{employee}/performance', [AdminEmployeeController::class, 'performance'])->name('employees.performance');
    Route::resource('services', ServiceController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('/appointments/{appointment}/assign', [AppointmentController::class, 'assignForm'])->name('appointments.assign');
    Route::post('/appointments/{appointment}/assign', [AppointmentController::class, 'assign'])->name('appointments.assign.store');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/appointments/{appointment}/rebook', [AppointmentController::class, 'rebook'])->name('appointments.rebook');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/notifications/recent-bookings', [AdminController::class, 'recentBookings'])->name('notifications.recent');
});

// Auth Routes
require __DIR__.'/auth.php';

// Health Check (UptimeRobot pings every 5 min)
Route::get('/health-check', function () {
    try {
        DB::connection()->getPdo();

        $expireStatus = 'skipped';
        $lastRun = Cache::store('database')->get('health_check_expire_last_run');

        if (!$lastRun || now()->diffInMinutes($lastRun) >= 30) {
            App\Models\Appointment::expirePast();
            Cache::store('database')->put('health_check_expire_last_run', now(), 60);
            $expireStatus = 'executed';
        }

        return response()->json([
            'status' => 'healthy',
            'database' => 'connected',
            'expire_check' => $expireStatus,
        ], 200);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'unhealthy',
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Locale Switch
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.supported_locales'))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');


