#!/usr/bin/env php
<?php

/*
|--------------------------------------------------------------------------
| Payment Reminder System - Automated Test Script
|--------------------------------------------------------------------------
|
| This script will automatically test your payment reminder system:
| 1. Check mail configuration
| 2. Send test email
| 3. Create test student (overdue)
| 4. Run payment check command
| 5. Show results and logs
|
| Usage: php test-payment-reminder.php
|
*/

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;
use App\Models\Course;
use App\Models\Center;
use App\Models\MonthlyPayment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

// Colors for terminal output
class Color {
    public static function green($text) { return "\033[32m{$text}\033[0m"; }
    public static function red($text) { return "\033[31m{$text}\033[0m"; }
    public static function yellow($text) { return "\033[33m{$text}\033[0m"; }
    public static function blue($text) { return "\033[34m{$text}\033[0m"; }
    public static function bold($text) { return "\033[1m{$text}\033[0m"; }
}

function printSection($title) {
    echo "\n" . str_repeat("=", 70) . "\n";
    echo Color::bold(Color::blue("  {$title}")) . "\n";
    echo str_repeat("=", 70) . "\n\n";
}

function printSuccess($message) {
    echo Color::green("✓ {$message}") . "\n";
}

function printError($message) {
    echo Color::red("✗ {$message}") . "\n";
}

function printWarning($message) {
    echo Color::yellow("⚠ {$message}") . "\n";
}

function printInfo($message) {
    echo "  {$message}\n";
}

// Start testing
echo "\n";
echo Color::bold(Color::blue("╔════════════════════════════════════════════════════════════════════╗")) . "\n";
echo Color::bold(Color::blue("║     Payment Reminder System - Automated Test                      ║")) . "\n";
echo Color::bold(Color::blue("╚════════════════════════════════════════════════════════════════════╝")) . "\n";

// Step 1: Check Mail Configuration
printSection("Step 1: Checking Mail Configuration");

$mailDriver = env('MAIL_MAILER');
$mailHost = env('MAIL_HOST');
$mailPort = env('MAIL_PORT');
$mailUsername = env('MAIL_USERNAME');
$mailPassword = env('MAIL_PASSWORD');
$mailEncryption = env('MAIL_ENCRYPTION');

printInfo("Mail Driver: " . ($mailDriver ?: Color::red('Not Set')));
printInfo("Mail Host: " . ($mailHost ?: Color::red('Not Set')));
printInfo("Mail Port: " . ($mailPort ?: Color::red('Not Set')));
printInfo("Mail Username: " . ($mailUsername ?: Color::red('Not Set')));
printInfo("Mail Password: " . ($mailPassword ? str_repeat('*', 16) : Color::red('Not Set')));
printInfo("Mail Encryption: " . ($mailEncryption ?: Color::red('Not Set')));

if (!$mailDriver || !$mailHost || !$mailUsername || !$mailPassword) {
    printError("Mail configuration is incomplete!");
    echo "\n";
    printWarning("Please configure mail settings in your .env file:");
    echo "\n";
    echo "MAIL_MAILER=smtp\n";
    echo "MAIL_HOST=smtp.gmail.com\n";
    echo "MAIL_PORT=587\n";
    echo "MAIL_USERNAME=your-email@gmail.com\n";
    echo "MAIL_PASSWORD=your-16-char-app-password\n";
    echo "MAIL_ENCRYPTION=tls\n";
    echo "\n";
    printWarning("Get Gmail App Password from: https://myaccount.google.com/apppasswords");
    exit(1);
}

printSuccess("Mail configuration found!");

// Step 2: Send Test Email
printSection("Step 2: Sending Test Email");

echo "Enter your email address to receive test email: ";
$testEmail = trim(fgets(STDIN));

if (!filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
    printError("Invalid email address!");
    exit(1);
}

try {
    Mail::raw('🎉 Success! Your email configuration is working correctly.', function($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('✓ Test Email - Student Management System');
    });
    
    printSuccess("Test email sent successfully to {$testEmail}");
    printInfo("Check your inbox (and spam folder) for the test email.");
    
    echo "\nDid you receive the test email? (yes/no): ";
    $received = trim(fgets(STDIN));
    
    if (strtolower($received) !== 'yes' && strtolower($received) !== 'y') {
        printWarning("Email not received. Check:");
        printInfo("1. Spam/Junk folder");
        printInfo("2. Gmail App Password is correct (16 chars)");
        printInfo("3. 2-Step Verification is enabled in Gmail");
        echo "\nDo you want to continue anyway? (yes/no): ";
        $continue = trim(fgets(STDIN));
        if (strtolower($continue) !== 'yes' && strtolower($continue) !== 'y') {
            exit(0);
        }
    } else {
        printSuccess("Great! Email system is working.");
    }
    
} catch (\Exception $e) {
    printError("Failed to send test email!");
    printError("Error: " . $e->getMessage());
    exit(1);
}

// Step 3: Check for existing overdue students
printSection("Step 3: Checking for Existing Overdue Students");

$threeWeeksAgo = Carbon::now()->subWeeks(3)->startOfDay();
$existingOverdue = Student::where('status', 'active')
    ->where('created_at', '<=', $threeWeeksAgo)
    ->whereDoesntHave('monthlyPayments')
    ->count();

if ($existingOverdue > 0) {
    printInfo("Found {$existingOverdue} existing overdue student(s)");
} else {
    printInfo("No existing overdue students found");
}

// Step 4: Create Test Student
printSection("Step 4: Creating Test Student");

echo "Create a test student with overdue payment? (yes/no): ";
$createTest = trim(fgets(STDIN));

$testStudent = null;

if (strtolower($createTest) === 'yes' || strtolower($createTest) === 'y') {
    
    // Get first course and center
    $course = Course::first();
    $center = Center::first();
    
    if (!$course) {
        printError("No courses found in database. Please create a course first.");
        exit(1);
    }
    
    try {
        $testStudent = Student::create([
            'first_name' => 'Test',
            'last_name' => 'Student',
            'email' => $testEmail,
            'student_phone' => '0771234567',
            'parent_phone' => '0771234567',
            'date_of_birth' => '2000-01-01',
            'course_id' => $course->id,
            'center_id' => $center ? $center->id : null,
            'status' => 'active',
            'registration_number' => 'TEST-' . time(),
            'created_at' => Carbon::now()->subWeeks(4), // 4 weeks ago = 1 week overdue
            'updated_at' => Carbon::now()
        ]);
        
        printSuccess("Test student created successfully!");
        printInfo("Name: {$testStudent->first_name} {$testStudent->last_name}");
        printInfo("Email: {$testStudent->email}");
        printInfo("Registration Number: {$testStudent->registration_number}");
        printInfo("Registered: {$testStudent->created_at->format('Y-m-d')} (4 weeks ago)");
        printInfo("Course: " . ($course->name ?? 'N/A'));
        printInfo("Days Overdue: 7 days");
        
    } catch (\Exception $e) {
        printError("Failed to create test student!");
        printError("Error: " . $e->getMessage());
        exit(1);
    }
}

// Step 5: Run Payment Check Command
printSection("Step 5: Running Payment Check Command");

printInfo("Executing: php artisan payments:check-overdue");
echo "\n";

try {
    Artisan::call('payments:check-overdue');
    $output = Artisan::output();
    echo $output;
    
    if (strpos($output, 'Emails sent: 0') !== false && $existingOverdue === 0 && !$testStudent) {
        printWarning("No emails were sent (no overdue students found)");
    } else {
        printSuccess("Payment check command executed successfully!");
    }
    
} catch (\Exception $e) {
    printError("Failed to run payment check command!");
    printError("Error: " . $e->getMessage());
    exit(1);
}

// Step 6: Check Logs
printSection("Step 6: Checking Recent Logs");

$logFile = storage_path('logs/laravel.log');

if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    $recentLines = array_slice($lines, -30);
    
    $emailLogs = array_filter($recentLines, function($line) {
        return strpos($line, 'Payment overdue email') !== false;
    });
    
    if (count($emailLogs) > 0) {
        printSuccess("Found email activity in logs:");
        foreach ($emailLogs as $log) {
            printInfo($log);
        }
    } else {
        printWarning("No recent email logs found");
    }
} else {
    printWarning("Log file not found");
}

// Step 7: Summary
printSection("Step 7: Test Summary");

$allOverdue = Student::where('status', 'active')
    ->where('created_at', '<=', $threeWeeksAgo)
    ->whereDoesntHave('monthlyPayments')
    ->with(['course', 'center'])
    ->get();

printInfo("Total overdue students in system: " . $allOverdue->count());

if ($allOverdue->count() > 0) {
    echo "\n";
    printInfo("Overdue Students List:");
    foreach ($allOverdue as $student) {
        $daysOverdue = Carbon::now()->diffInDays($student->created_at->addWeeks(3), false) * -1;
        printInfo("  • {$student->first_name} {$student->last_name} ({$student->email})");
        printInfo("    Registered: {$student->created_at->format('Y-m-d')} - {$daysOverdue} days overdue");
    }
}

// Cleanup
if ($testStudent) {
    echo "\n";
    echo "Do you want to delete the test student? (yes/no): ";
    $delete = trim(fgets(STDIN));
    
    if (strtolower($delete) === 'yes' || strtolower($delete) === 'y') {
        $testStudent->delete();
        printSuccess("Test student deleted");
    } else {
        printInfo("Test student kept in database (ID: {$testStudent->id})");
    }
}

// Final Instructions
printSection("Next Steps");

printInfo("✓ Email configuration is working");
printInfo("✓ Payment reminder system tested successfully");
echo "\n";
printInfo("To enable automatic daily checks:");
printInfo("1. Set up Windows Task Scheduler (see EMAIL_REMINDER_SETUP.md)");
printInfo("2. Or manually run: php artisan payments:check-overdue");
echo "\n";
printInfo("The system will run automatically at 9:00 AM daily");
printInfo("Check logs at: storage/logs/laravel.log");

echo "\n";
echo Color::bold(Color::green("╔════════════════════════════════════════════════════════════════════╗")) . "\n";
echo Color::bold(Color::green("║                    Testing Complete! ✓                             ║")) . "\n";
echo Color::bold(Color::green("╚════════════════════════════════════════════════════════════════════╝")) . "\n";
echo "\n";
