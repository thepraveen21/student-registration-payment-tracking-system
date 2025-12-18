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

## 🧪 Create Test Student (Overdue)

Run in `php artisan tinker`:

```php
// Create a student who registered 4 weeks ago (overdue by 1 week)
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
    'created_at' => now()->subWeeks(4),  // 4 weeks ago = overdue!
    'updated_at' => now()
]);

echo "Created test student ID: {$student->id}\n";
echo "Email: {$student->email}\n";
echo "Registered: {$student->created_at->format('Y-m-d')}\n";
```

Now run:
```bash
php artisan payments:check-overdue
```

You should receive an email at your test address!

## 📊 Check Current Overdue Students

```php
php artisan tinker
```

```php
// See all students 3+ weeks old without payment
$threeWeeksAgo = \Carbon\Carbon::now()->subWeeks(3)->startOfDay();
$overdue = \App\Models\Student::where('status', 'active')
    ->where('created_at', '<=', $threeWeeksAgo)
    ->whereDoesntHave('monthlyPayments')
    ->with(['course', 'center'])
    ->get();

echo "Found {$overdue->count()} overdue students:\n\n";

foreach($overdue as $s) {
    $days = \Carbon\Carbon::now()->diffInDays($s->created_at->addWeeks(3), false) * -1;
    echo "- {$s->first_name} {$s->last_name} ({$s->email})\n";
    echo "  Registered: {$s->created_at->format('Y-m-d')} ({$days} days overdue)\n";
    echo "  Course: " . ($s->course->name ?? 'N/A') . "\n\n";
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
  - Days overdue (highlighted in red)
  - Registration details
  - Course and center information
  - Payment methods
  - Contact button

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
