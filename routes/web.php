<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MonthlyPaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdvancedReportController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;

// Reception-specific controllers
use App\Http\Controllers\Reception\ReceptionStudentController;
use App\Http\Controllers\Reception\ReceptionPaymentController;
use App\Http\Controllers\Reception\AttendanceController;
use App\Http\Controllers\ReceptionInvoiceController;
use App\Http\Controllers\Reception\QRCodeController;
use App\Http\Controllers\Reception\ReportController;


// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Student QR code verification and attendance
Route::get('/student/verify/{code}', [QRController::class, 'verify'])->name('student.verify');
Route::get('/qr/{code}', [QRController::class, 'show'])->name('qr.show');

// QR scan attendance
Route::get('/reception/qr-scan/{code}', [QRController::class, 'storeAttendanceFromScanner'])
    ->name('reception.qr.scan');

// Test page to view all QR codes
Route::get('/qr-test', [QRController::class, 'test'])->name('qr.test');

// Admin Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

// Reception Dashboard
Route::get('/Reception', [DashboardController::class, 'indexReception'])
    ->middleware(['auth', 'verified', 'role:receptionist'])
    ->name('Reception');

// Admin Pages
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

    Route::resource('/admin/payments', MonthlyPaymentController::class)->names([
        'index' => 'admin.payments.index',
        'create' => 'admin.payments.create',
        'store' => 'admin.payments.store',
        'show' => 'admin.payments.show',
        'edit' => 'admin.payments.edit',
        'update' => 'admin.payments.update',
        'destroy' => 'admin.payments.destroy',
    ]);

    Route::get('/admin/students/{id}/course', [MonthlyPaymentController::class, 'getCourse'])->name('admin.students.get_course');

    // Reports
    Route::get('/admin/reports', [AdvancedReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/course-wise-students', [AdvancedReportController::class, 'courseWiseStudents'])->name('admin.reports.course-wise-students');
    Route::get('/admin/reports/payment-status', [AdvancedReportController::class, 'paymentStatus'])->name('admin.reports.payment-status');
    Route::get('/admin/reports/payment-wise-students', [AdvancedReportController::class, 'paymentWiseStudents'])->name('admin.reports.payment-wise-students');
    Route::get('/admin/reports/overdue-cases', [AdvancedReportController::class, 'overdueCases'])->name('admin.reports.overdue-cases');
    Route::get('/admin/reports/revenue', [AdvancedReportController::class, 'revenue'])->name('admin.reports.revenue');
    Route::get('/admin/reports/enrollment-summary', [AdvancedReportController::class, 'enrollmentSummary'])->name('admin.reports.enrollment-summary');
    Route::get('/admin/reports/notifications', [AdvancedReportController::class, 'notifications'])->name('admin.reports.notifications');

    // Notifications
    Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/admin/notifications/create', [NotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post('/admin/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    Route::resource('/admin/notifications', NotificationController::class)->names([
        'index' => 'admin.notifications.index',
        'create' => 'admin.notifications.create',
        'store' => 'admin.notifications.store',
        'show' => 'admin.notifications.show',
        'edit' => 'admin.notifications.edit',
        'update' => 'admin.notifications.update',
        'destroy' => 'admin.notifications.destroy',
    ]);
    Route::post('/admin/notifications/send-overdue', [NotificationController::class, 'sendOverdueNotifications'])->name('admin.notifications.send-overdue');
    Route::post('/admin/notifications/retry-failed', [NotificationController::class, 'retryFailed'])->name('admin.notifications.retry-failed');
    Route::patch('/admin/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
    Route::post('/admin/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
    Route::delete('/admin/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::get('/admin/notifications/overdue-preview', [NotificationController::class, 'overduePreview'])->name('admin.notifications.overdue-preview');

    // User approval routes for admins
    Route::post('/admin/users/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('admin.users.approve');
    Route::post('/admin/users/{user}/reject', [\App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])->name('admin.users.reject');

    Route::get('admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});

// Reception Pages
Route::middleware(['auth', 'role:receptionist'])
    ->prefix('reception')
    ->name('reception.')
    ->group(function () {

    Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('dashboard');

    // Students
    Route::resource('students', ReceptionStudentController::class);
    Route::get('/students/{student}/monthly-payments', [ReceptionPaymentController::class, 'monthlyPayments'])->name('students.monthly-payments');
    Route::post('/students/{student}/monthly-payments', [ReceptionPaymentController::class, 'storeMonthlyPayments'])->name('students.store-monthly-payments');

    // Payments CRUD
    Route::resource('payments', ReceptionPaymentController::class)->names([
        'index' => 'payments.index',
        'create' => 'payments.create',
        'store' => 'payments.store',
        'show' => 'payments.show',
        'edit' => 'payments.edit',
        'update' => 'payments.update',
        'destroy' => 'payments.destroy',
    ]);

    // IMPORTANT — FIXED DUPLICATE AND NAMING
    Route::post('payments/get-student', [ReceptionPaymentController::class, 'getStudent'])
        ->name('payments.getStudent');

    // Payment popup
    Route::get('/payments/popup/{student}', [ReceptionPaymentController::class, 'paymentPopup'])
        ->name('payments.popup');

    // Find student by QR
    Route::get('payments/find-student/{qr}', 
        [ReceptionPaymentController::class, 'findStudentByQR']
    )->name('payments.find-student');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    // Invoices
    Route::resource('invoices', ReceptionInvoiceController::class);

    // QR code management
    Route::get('/qrcodes/manage', [QRCodeController::class, 'manage'])->name('qrcodes.manage');
    Route::post('/qrcodes/generate', [QRCodeController::class, 'generate'])->name('qrcodes.generate');
    Route::get('/qrcodes/print-batch', [QRCodeController::class, 'printBatch'])->name('qrcodes.print-batch');
    Route::get('/qrcodes/print/{student}', [QRCodeController::class, 'printSingle'])->name('qrcodes.print');
    Route::post('/qrcodes/assign', [QRCodeController::class, 'assign'])->name('qrcodes.assign');
    Route::delete('/qrcodes/{qrCode}/unassign', [QRCodeController::class, 'unassign'])->name('qrcodes.unassign');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');



    // Settings
    Route::get('/settings', [ReceptionController::class, 'settings'])->name('settings');
});

// Reception schedule
Route::prefix('reception')->middleware(['auth', 'role:receptionist'])->group(function () {
    Route::get('/schedule', [App\Http\Controllers\ReceptionController::class, 'schedule'])->name('reception.schedule.index');
    Route::post('/schedule', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'store'])->name('reception.schedule.store');
    Route::get('/schedule/{schedule}/edit', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'edit'])->name('reception.schedule.edit');
    Route::put('/schedule/{schedule}', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'update'])->name('reception.schedule.update');
    Route::delete('/schedule/{schedule}', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'destroy'])->name('reception.schedule.destroy');
    Route::get('/tasks/{task}/edit', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'editTask'])->name('reception.task.edit');
    Route::put('/tasks/{task}', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'updateTask'])->name('reception.task.update');
    Route::delete('/tasks/{task}', [App\Http\Controllers\Reception\ReceptionScheduleController::class, 'destroyTask'])->name('reception.task.destroy');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/centers/create', [App\Http\Controllers\CenterController::class, 'create'])
        ->name('centers.create');
    Route::post('/centers', [App\Http\Controllers\CenterController::class, 'store'])
        ->name('centers.store');
    Route::delete('/centers/{id}', [App\Http\Controllers\CenterController::class, 'destroy'])
        ->name('centers.destroy');

    Route::get('/courses/create', [CourseController::class, 'create'])
        ->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])
        ->name('courses.store');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');
});
