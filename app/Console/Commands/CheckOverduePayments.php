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
        $this->info('Checking for students with overdue monthly payments...');
        $this->info('System: 4 weeks = 1 month | Payment reminder sent during week 3 of each month');
        $this->info('');
        
        $today = Carbon::now();
        
        // Get all active students
        $activeStudents = Student::where('status', 'active')
            ->with(['course', 'center', 'monthlyPayments'])
            ->get();
        
        $emailsSent = 0;
        $emailsFailed = 0;
        $studentsChecked = 0;
        
        foreach ($activeStudents as $student) {
            $registrationDate = Carbon::parse($student->created_at);
            $daysSinceRegistration = $registrationDate->diffInDays($today);
            
            // Calculate current month (4 weeks = 1 month = 28 days)
            $currentMonthNumber = floor($daysSinceRegistration / 28) + 1;
            
            // Only check months 1-4 (4 months course)
            if ($currentMonthNumber > 4) {
                continue;
            }
            
            // Calculate which day of the current month cycle (0-27)
            $dayInCurrentMonth = $daysSinceRegistration % 28;
            
            // Week 3 = days 14-20 (0-indexed, so checking 14-20)
            $isWeek3 = ($dayInCurrentMonth >= 14 && $dayInCurrentMonth <= 20);
            
            if (!$isWeek3) {
                continue; // Not in week 3, skip this student
            }
            
            $studentsChecked++;
            
            // Check if payment exists for current month
            $paymentExists = $student->monthlyPayments()
                ->where('month_number', $currentMonthNumber)
                ->exists();
            
            if ($paymentExists) {
                $this->info("  ✓ {$student->first_name} {$student->last_name} - Month {$currentMonthNumber} - Already paid");
                continue; // Payment exists, no reminder needed
            }
            
            // No payment for current month, send reminder
            try {
                if (filter_var($student->email, FILTER_VALIDATE_EMAIL)) {
                    
                    $daysIntoWeek3 = $dayInCurrentMonth - 14 + 1; // Days into week 3
                    
                    Mail::to($student->email)->send(new PaymentOverdueMail(
                        $student, 
                        $daysIntoWeek3,
                        $currentMonthNumber
                    ));
                    
                    $this->info("  ✓ Sent reminder to: {$student->first_name} {$student->last_name} ({$student->email})");
                    $this->info("    Month {$currentMonthNumber} - Week 3, Day {$daysIntoWeek3}");
                    $emailsSent++;
                    
                    // Log the action
                    Log::info('Monthly payment reminder sent', [
                        'student_id' => $student->id,
                        'student_name' => $student->first_name . ' ' . $student->last_name,
                        'email' => $student->email,
                        'month_number' => $currentMonthNumber,
                        'days_since_registration' => $daysSinceRegistration,
                        'day_in_month' => $dayInCurrentMonth,
                        'registration_date' => $registrationDate->format('Y-m-d'),
                    ]);
                } else {
                    $this->warn("  ✗ Invalid email for: {$student->first_name} {$student->last_name} ({$student->email})");
                    $emailsFailed++;
                }
            } catch (\Exception $e) {
                $this->error("  ✗ Failed to send email to {$student->email}: {$e->getMessage()}");
                $emailsFailed++;
                
                Log::error('Failed to send monthly payment reminder', [
                    'student_id' => $student->id,
                    'email' => $student->email,
                    'month_number' => $currentMonthNumber,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        $this->info("\n" . str_repeat('=', 60));
        $this->info("Summary:");
        $this->info("  Active students: " . $activeStudents->count());
        $this->info("  Students in week 3 of their month: {$studentsChecked}");
        $this->info("  Reminder emails sent: {$emailsSent}");
        $this->info("  Failed: {$emailsFailed}");
        $this->info(str_repeat('=', 60));
        
        return Command::SUCCESS;
    }
}
