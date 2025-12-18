# Email Payment Reminder Setup Guide

## Overview
This system automatically checks for students who haven't paid within 3 weeks of registration and sends them email reminders.

## How It Works

1. **Daily Check**: Every day at 9:00 AM, the system checks for students who:
   - Registered 3+ weeks ago (21 days or more)
   - Have not made any monthly payments
   - Have an active status

2. **Email Sent**: An automated email reminder is sent to their Gmail address with:
   - Days overdue
   - Registration details
   - Course information
   - Payment instructions

## Setup Instructions

### Step 1: Configure Email Settings in `.env` file

Open your `.env` file and add/update these settings:

#### For Gmail SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### How to Get Gmail App Password:
1. Go to your Google Account: https://myaccount.google.com/
2. Select Security
3. Enable 2-Step Verification if not already enabled
4. Under "Signing in to Google", select "App passwords"
5. Select app: "Mail"
6. Select device: "Other (Custom name)" - enter "Student Management System"
7. Click "Generate"
8. Copy the 16-character password
9. Paste it into `MAIL_PASSWORD` in your `.env` file (without spaces)

### Step 2: Test Email Configuration

Run this command to test if emails are working:

```bash
php artisan tinker
```

Then run:
```php
Mail::raw('Test email from Student Management System', function($msg) {
    $msg->to('your-test-email@gmail.com')->subject('Test Email');
});
```

If successful, you should receive the test email.

### Step 3: Run the Payment Check Manually (Testing)

Test the command manually before scheduling:

```bash
php artisan payments:check-overdue
```

This will:
- Check all students who are 3+ weeks overdue
- Display a summary of emails sent
- Log all actions

### Step 4: Enable Task Scheduling

The command is already scheduled to run daily at 9:00 AM. To enable it:

#### On Windows (Development):
1. Open Task Scheduler
2. Create a new task
3. Set trigger to run at startup and repeat every 1 minute
4. Action: Run program
   - Program: `php`
   - Arguments: `E:\Project\Student Management System\artisan schedule:run`
   - Start in: `E:\Project\Student Management System`

#### On Linux/Ubuntu (Production):
Add this to your crontab:
```bash
crontab -e
```

Add this line:
```
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

#### Quick Test (Any OS):
Run the scheduler once manually:
```bash
php artisan schedule:run
```

### Step 5: Monitor Logs

Check logs to see if emails are being sent:

```bash
# View Laravel logs
tail -f storage/logs/laravel.log

# On Windows:
Get-Content storage\logs\laravel.log -Wait -Tail 50
```

## Command Usage

### Manual Execution
```bash
# Check and send overdue payment reminders
php artisan payments:check-overdue
```

### View Scheduled Tasks
```bash
php artisan schedule:list
```

### Test Schedule Without Waiting
```bash
php artisan schedule:test
```

## Customization Options

### Change Schedule Time
Edit `app/Console/Kernel.php`:
```php
// Current: Runs at 9:00 AM daily
$schedule->command('payments:check-overdue')->dailyAt('09:00')

// Change to run at different times:
$schedule->command('payments:check-overdue')->dailyAt('14:00') // 2:00 PM
$schedule->command('payments:check-overdue')->twiceDaily(9, 17) // 9 AM and 5 PM
$schedule->command('payments:check-overdue')->weekly() // Once per week
```

### Change 3-Week Period
Edit `app/Console/Commands/CheckOverduePayments.php`, line 23:
```php
// Current: 3 weeks
$threeWeeksAgo = Carbon::now()->subWeeks(3)->startOfDay();

// Change to different periods:
$threeWeeksAgo = Carbon::now()->subWeeks(2)->startOfDay(); // 2 weeks
$threeWeeksAgo = Carbon::now()->subDays(30)->startOfDay(); // 30 days
$threeWeeksAgo = Carbon::now()->subMonth()->startOfDay(); // 1 month
```

### Customize Email Template
Edit `resources/views/emails/payment_overdue.blade.php` to change:
- Design and colors
- Message content
- Contact information
- Add your center's phone number

## Troubleshooting

### Emails Not Sending?

1. **Check Gmail Settings**:
   - 2-Step Verification must be enabled
   - Use App Password, not your regular password
   - Check for any security alerts from Google

2. **Check Laravel Logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Test SMTP Connection**:
   ```bash
   php artisan tinker
   ```
   ```php
   Mail::raw('Test', function($msg) { $msg->to('test@gmail.com')->subject('Test'); });
   ```

4. **Check Firewall**: Ensure port 587 (or 465) is not blocked

5. **Common Errors**:
   - "Connection refused": Check MAIL_HOST and MAIL_PORT
   - "Authentication failed": Verify MAIL_USERNAME and MAIL_PASSWORD
   - "SSL/TLS error": Check MAIL_ENCRYPTION setting

### No Students Being Detected?

Check if there are students who meet the criteria:
```bash
php artisan tinker
```
```php
$threeWeeksAgo = \Carbon\Carbon::now()->subWeeks(3)->startOfDay();
$students = \App\Models\Student::where('status', 'active')
    ->where('created_at', '<=', $threeWeeksAgo)
    ->whereDoesntHave('monthlyPayments')
    ->count();
echo "Found {$students} overdue students";
```

### Schedule Not Running?

1. **Verify cron/task scheduler is running**:
   ```bash
   php artisan schedule:list
   ```

2. **Run manually to test**:
   ```bash
   php artisan schedule:run
   ```

3. **Check if scheduler is working**:
   ```bash
   php artisan schedule:test
   ```

## Production Deployment

### Before Going Live:

1. ✅ Test email sending with real Gmail account
2. ✅ Run manual command to verify logic
3. ✅ Set up proper cron job or Windows Task Scheduler
4. ✅ Monitor logs for first few days
5. ✅ Update email template with actual contact info
6. ✅ Consider using email queue for better performance

### Using Email Queue (Recommended for Production):

1. Update `.env`:
   ```env
   QUEUE_CONNECTION=database
   ```

2. Create jobs table:
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

3. Start queue worker:
   ```bash
   php artisan queue:work --daemon
   ```

4. Update command to use queue:
   Edit `CheckOverduePayments.php`, change:
   ```php
   Mail::to($student->email)->send(new PaymentOverdueMail($student, $daysOverdue));
   ```
   To:
   ```php
   Mail::to($student->email)->queue(new PaymentOverdueMail($student, $daysOverdue));
   ```

## Support

If you encounter any issues:
1. Check logs: `storage/logs/laravel.log`
2. Enable debug mode in `.env`: `APP_DEBUG=true`
3. Run tests manually with verbose output
4. Check email provider's documentation (Gmail, etc.)

## Security Notes

- Never commit `.env` file to version control
- Use App Passwords, not regular passwords
- Keep email credentials secure
- Monitor email sending to avoid spam complaints
- Consider rate limiting for production

---

**Last Updated**: December 18, 2025
