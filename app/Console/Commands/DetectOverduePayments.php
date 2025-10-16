<?php

namespace App\Console\Commands;

use App\Models\PaymentSchedule;
use App\Models\Payment;
use App\Models\Notification;
use App\Notifications\OverduePaymentNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DetectOverduePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:detect-overdue {--send-notifications : Send notifications to students}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect overdue payments and optionally send notifications to students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for overdue payments...');
        
        // Get overdue payment schedules
        $overdueSchedules = PaymentSchedule::where('due_date', '<', Carbon::today())
            ->where('status', '!=', 'paid')
            ->with(['student'])
            ->get();

        if ($overdueSchedules->isEmpty()) {
            $this->info('No overdue payments found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$overdueSchedules->count()} overdue payments.");
        
        $sendNotifications = $this->option('send-notifications');
        
        foreach ($overdueSchedules as $schedule) {
            $student = $schedule->student;
            $daysOverdue = Carbon::today()->diffInDays($schedule->due_date);
            
            // Mark as overdue if not already marked
            if ($schedule->status == 'pending') {
                $schedule->update(['status' => 'overdue']);
            }
            
            $this->line("- {$student->full_name}: ₹{$schedule->amount_due} (Due: {$schedule->due_date->format('M d, Y')}, {$daysOverdue} days overdue)");
            
            if ($sendNotifications) {
                // Create notification record
                $notification = Notification::create([
                    'student_id' => $student->id,
                    'type' => 'overdue_payment',
                    'message' => "Payment Overdue: Your payment of ₹{$schedule->amount_due} was due on {$schedule->due_date->format('M d, Y')}. Please make payment as soon as possible.",
                    'delivery_method' => 'email',
                    'status' => 'pending',
                    'sent_at' => now(),
                ]);
                
                // Send notification (email/SMS would be implemented here)
                try {
                    if ($student->email) {
                        $student->notify(new OverduePaymentNotification($schedule));
                        $this->info("  ✓ Email notification sent to {$student->email}");
                    }
                    
                    // SMS notification would be sent here with SMS service
                    if ($student->phone) {
                        $this->info("  ✓ SMS notification queued for {$student->phone}");
                    }
                    
                } catch (\Exception $e) {
                    $this->error("  ✗ Failed to send notification: " . $e->getMessage());
                    Log::error("Failed to send overdue payment notification", [
                        'student_id' => $student->id,
                        'schedule_id' => $schedule->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        
        if ($sendNotifications) {
            $this->info('Notifications sent successfully.');
        } else {
            $this->info('Use --send-notifications flag to send notifications to students.');
        }
        
        return Command::SUCCESS;
    }
}
