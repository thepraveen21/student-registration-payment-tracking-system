# Quick Test Guide - Payment Reminder System

## ⚡ Quick Setup (5 Minutes)

### 1. Configure Gmail in `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx  # 16-char App Password from Google
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Student Management System"
```

### 2. Get Gmail App Password
1. Visit: https://myaccount.google.com/apppasswords
2. Create password for "Mail" > "Other (Student System)"
3. Copy the 16-character code (without spaces)
4. Paste into `MAIL_PASSWORD` in `.env`

### 3. Test It!
```bash
# Test email sending
php artisan tinker
Mail::raw('Test from Student System', function($msg) { 
    $msg->to('your-email@gmail.com')->subject('Test'); 
});

# Run the payment check
php artisan payments:check-overdue
```

## 🧪 Create Test Student (Will Receive Reminder)

Run in `php artisan tinker`:

```php
// Create a student in week 3 of month 1 (day 16 = 2 weeks + 2 days ago)
$student = \App\Models\Student::create([
    'first_name' => 'Test',
    'last_name' => 'Student',
    'email' => 'your-test-email@gmail.com',  // Your email
    'student_phone' => '0771234567',
    'parent_phone' => '0771234567',
    'date_of_birth' => '2000-01-01',
    'course_id' => 1,  // Make sure course ID 1 exists
    'center_id' => 1,  // Make sure center ID 1 exists
    'status' => 'active',
    'registration_number' => 'TEST-' . time(),
    'created_at' => now()->subDays(16),  // 16 days ago = Month 1, Week 3, Day 3
    'updated_at' => now()
]);

echo "Created test student ID: {$student->id}\n";
echo "Email: {$student->email}\n";
echo "Registered: {$student->created_at->format('Y-m-d')}\n";
echo "Days since registration: 16 (Month 1, Week 3)\n";
echo "Should receive reminder: YES (no payment for month 1)\n";
```

**Alternative - Test Month 2 reminder:**
```php
// Student in month 2, week 3 (around 6 weeks ago)
$student2 = \App\Models\Student::create([
    'first_name' => 'Test2',
    'last_name' => 'Student',
    'email' => 'your-test-email@gmail.com',
    'student_phone' => '0771234567',
    'parent_phone' => '0771234567',
    'date_of_birth' => '2000-01-01',
    'course_id' => 1,
    'center_id' => 1,
    'status' => 'active',
    'registration_number' => 'TEST2-' . time(),
    'created_at' => now()->subDays(44),  // 44 days = Month 2, Week 3, Day 2
    'updated_at' => now()
]);
```

Now run:
```bash
php artisan payments:check-overdue
```

You should receive an email showing the month number and days into week 3!

## 📊 Check Who Will Get Reminders Today

```bash
php artisan tinker
```

```php
use Carbon\Carbon;
use App\Models\Student;

$today = Carbon::now();
$activeStudents = Student::where('status', 'active')
    ->with(['course', 'center', 'monthlyPayments'])
    ->get();

$willGetReminder = [];

foreach ($activeStudents as $student) {
    $daysSinceReg = Carbon::parse($student->created_at)->diffInDays($today);
    $currentMonth = floor($daysSinceReg / 28) + 1;
    $dayInMonth = $daysSinceReg % 28;
    $isWeek3 = ($dayInMonth >= 14 && $dayInMonth <= 20);
    
    if ($currentMonth <= 4 && $isWeek3) {
        $hasPayment = $student->monthlyPayments->where('month_number', $currentMonth)->isNotEmpty();
        if (!$hasPayment) {
            $daysIntoWeek3 = $dayInMonth - 14 + 1;
            $willGetReminder[] = [
                'name' => "{$student->first_name} {$student->last_name}",
                'email' => $student->email,
                'registered' => $student->created_at->format('Y-m-d'),
                'month' => $currentMonth,
                'week3_day' => $daysIntoWeek3,
                'course' => $student->course->name ?? 'N/A'
            ];
        }
    }
}

echo "Students who will receive reminders today: " . count($willGetReminder) . "\n\n";

foreach ($willGetReminder as $s) {
    echo "- {$s['name']} ({$s['email']})\n";
    echo "  Registered: {$s['registered']}\n";
    echo "  Current: Month {$s['month']}, Week 3, Day {$s['week3_day']}\n";
    echo "  Course: {$s['course']}\n\n";
}
```

## 🔧 Common Commands

```bash
# Run payment check manually
php artisan payments:check-overdue

# View scheduled tasks
php artisan schedule:list

# Run scheduler once (runs all due tasks)
php artisan schedule:run

# View logs
tail -f storage/logs/laravel.log          # Linux/Mac
Get-Content storage\logs\laravel.log -Wait -Tail 20  # Windows PowerShell

# Clear cache
php artisan config:clear
php artisan cache:clear
```

## ✅ Verification Checklist

- [ ] Gmail App Password configured in `.env`
- [ ] Test email sent successfully
- [ ] Test student created (4+ weeks old)
- [ ] Command runs without errors
- [ ] Email received in inbox (check spam folder)
- [ ] Email content looks correct
- [ ] Schedule configured (runs at 9 AM daily)
- [ ] Logs show successful execution

## 🔍 Troubleshooting Quick Fixes

| Problem | Solution |
|---------|----------|
| "Connection refused" | Check MAIL_HOST and MAIL_PORT in `.env` |
| "Authentication failed" | Verify Gmail App Password (16 chars, no spaces) |
| "No students found" | Create test student with old `created_at` date |
| Email not received | Check spam folder, verify email address |
| Schedule not running | Set up cron job or Task Scheduler |

## 📧 Email Preview

Students will receive an email with:
- **Subject**: "Urgent: Class Fee Payment Reminder - Action Required"
- **Content**:
  - Student name and registration number
  - Current month number (1-4)
  - Days into week 3 (payment reminder period)
  - Registration date
  - Course and center information
  - Payment instructions
  - Contact information
- **Email Template**: `resources/views/emails/payment_overdue.blade.php`
- **Mailable Class**: `App\Mail\PaymentOverdueMail`

## 🚀 Going Live

1. Test with your own email first
2. Create 1-2 test students
3. Verify emails are received
4. Update email template with real contact info
5. Set up cron job/scheduler
6. Monitor for first week

---

**Quick Help:**
- Full documentation: `EMAIL_REMINDER_SETUP.md`
- View logs: `storage/logs/laravel.log`
- Test command: `php artisan payments:check-overdue`
