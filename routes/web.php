<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdvancedReportController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;

// Reception-specific controllers
use App\Http\Controllers\Reception\ReceptionStudentController;
use App\Http\Controllers\Reception\ReceptionPaymentController;
use App\Http\Controllers\ReceptionInvoiceController;
// use App\Http\Controllers\Reception\ReceptionUserController;


// ✅ Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Admin Dashboard (only for admin)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

// ✅ Reception Dashboard (only for receptionist)
Route::get('/Reception', [DashboardController::class, 'indexReception'])
    ->middleware(['auth', 'verified', 'role:receptionist'])
    ->name('Reception');

// ✅ Admin Pages
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('/admin/students', StudentController::class)->names([
        'index' => 'admin.students.index',
        'create' => 'admin.students.create',
        'store' => 'admin.students.store',
        'show' => 'admin.students.show',
        'edit' => 'admin.students.edit',
        'update' => 'admin.students.update',
        'destroy' => 'admin.students.destroy',
    ]);
    Route::resource('/admin/payments', PaymentController::class)->names([
        'index' => 'admin.payments.index',
        'create' => 'admin.payments.create',
        'store' => 'admin.payments.store',
        'show' => 'admin.payments.show',
        'edit' => 'admin.payments.edit',
        'update' => 'admin.payments.update',
        'destroy' => 'admin.payments.destroy',
    ]);
    
    // Reports
    Route::get('/admin/reports', [AdvancedReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/course-wise-students', [AdvancedReportController::class, 'courseWiseStudents'])->name('admin.reports.course-wise-students');
    Route::get('/admin/reports/payment-status', [AdvancedReportController::class, 'paymentStatus'])->name('admin.reports.payment-status');
    Route::get('/admin/reports/overdue-cases', [AdvancedReportController::class, 'overdueCases'])->name('admin.reports.overdue-cases');
    Route::get('/admin/reports/revenue', [AdvancedReportController::class, 'revenue'])->name('admin.reports.revenue');
    Route::get('/admin/reports/enrollment-summary', [AdvancedReportController::class, 'enrollmentSummary'])->name('admin.reports.enrollment-summary');
    Route::get('/admin/reports/notifications', [AdvancedReportController::class, 'notifications'])->name('admin.reports.notifications');

    // Notification routes
    Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/admin/notifications/create', [NotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post('/admin/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    Route::post('/admin/notifications/send-overdue', [NotificationController::class, 'sendOverdueNotifications'])->name('admin.notifications.send-overdue');
    Route::post('/admin/notifications/retry-failed', [NotificationController::class, 'retryFailed'])->name('admin.notifications.retry-failed');
    Route::patch('/admin/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
    Route::post('/admin/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
    Route::delete('/admin/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::get('/admin/notifications/overdue-preview', [NotificationController::class, 'overduePreview'])->name('admin.notifications.overdue-preview');
    
    Route::get('admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});

// ✅ Reception Pages
Route::middleware(['auth', 'role:receptionist'])->prefix('reception')->name('reception.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('dashboard');

    // Students CRUD
    Route::resource('students', ReceptionStudentController::class);

    // Payments CRUD
    Route::resource('payments', ReceptionPaymentController::class);

    // Invoices
    Route::resource('invoices', ReceptionInvoiceController::class);

    // Reports
    Route::get('/reports', [ReceptionController::class, 'reports'])->name('reports.index');

    // Settings
    Route::get('/settings', [ReceptionController::class, 'settings'])->name('settings');

    // User management (optional for reception)
    // Route::resource('users', ReceptionUserController::class);
});

// ✅ Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth'])->group(function () {
//     // Students Routes
//     Route::resource('students', StudentController::class);
    
//     // Additional student routes
//     Route::get('students/{student}/qr-code', [StudentController::class, 'generateQrCode'])->name('students.qr-code');
//     Route::get('students/{student}/profile', [StudentController::class, 'profile'])->name('students.profile');
// });

require __DIR__.'/auth.php';
