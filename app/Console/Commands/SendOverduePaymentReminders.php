<?php

namespace App\Console\Commands;

use App\Mail\OverduePaymentReminder;
use App\Models\Student;
use App\Models\PaymentSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendOverduePaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:send-overdue-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to students with overdue payments.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueStudents = Student::whereHas('paymentSchedules', function ($query) {
            $query->where('status', '!=', 'paid')
                  ->where('due_date', '<=', Carbon::now()->subWeeks(2));
        })->get();

        foreach ($overdueStudents as $student) {
            Mail::to($student->email)->send(new OverduePaymentReminder($student));
            $this->info("Overdue payment reminder sent to: {$student->email}");
        }

        $this->info('Overdue payment reminders sent successfully.');
    }
}
