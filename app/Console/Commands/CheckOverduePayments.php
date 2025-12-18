<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\MonthlyPayment;
use App\Mail\PaymentOverdueMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckOverduePayments extends Command
{
    protected $signature = 'payments:check-overdue';
    protected $description = 'Send email reminder to students who have not paid within 3 weeks of registration';

    public function handle()
    {
        $this->info('Checking for students with overdue payments...');
        
        // Get date 3 weeks ago (21 days)
        $threeWeeksAgo = Carbon::now()->subWeeks(3)->startOfDay();
        
        // Find students who:
        // 1. Registered 3+ weeks ago (created_at <= 3 weeks ago)
        // 2. Have no monthly payments at all
        // 3. Are active students
        $overdueStudents = Student::where('status', 'active')
            ->where('created_at', '<=', $threeWeeksAgo)
            ->whereDoesntHave('monthlyPayments')
            ->with(['course', 'center'])
            ->get();
        
        $emailsSent = 0;
        $emailsFailed = 0;
        
        foreach ($overdueStudents as $student) {
            try {
                // Calculate how many days overdue
                $registrationDate = Carbon::parse($student->created_at);
                $dueDate = $registrationDate->copy()->addWeeks(3);
                $daysOverdue = Carbon::now()->diffInDays($dueDate, false) * -1;
                
                if ($daysOverdue > 0) {
                    // Only send if email is valid
                    if (filter_var($student->email, FILTER_VALIDATE_EMAIL)) {
                        Mail::to($student->email)->send(new PaymentOverdueMail($student, $daysOverdue));
                        
                        $this->info("✓ Sent reminder to: {$student->first_name} {$student->last_name} ({$student->email}) - {$daysOverdue} days overdue");
                        $emailsSent++;
                        
                        // Log the action
                        Log::info('Payment overdue email sent', [
                            'student_id' => $student->id,
                            'student_name' => $student->first_name . ' ' . $student->last_name,
                            'email' => $student->email,
                            'registration_date' => $registrationDate->format('Y-m-d'),
                            'days_overdue' => $daysOverdue,
                        ]);
                    } else {
                        $this->warn("✗ Invalid email for: {$student->first_name} {$student->last_name} ({$student->email})");
                        $emailsFailed++;
                    }
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed to send email to {$student->email}: {$e->getMessage()}");
                $emailsFailed++;
                
                Log::error('Failed to send payment overdue email', [
                    'student_id' => $student->id,
                    'email' => $student->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        $this->info("\n" . str_repeat('=', 50));
        $this->info("Summary:");
        $this->info("  Total overdue students: " . $overdueStudents->count());
        $this->info("  Emails sent: {$emailsSent}");
        $this->info("  Emails failed: {$emailsFailed}");
        $this->info(str_repeat('=', 50));
        
        return Command::SUCCESS;
    }
}
