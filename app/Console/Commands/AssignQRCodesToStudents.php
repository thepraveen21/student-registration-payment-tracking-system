<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AssignQRCodesToStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:assign {count?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign unassigned QR codes to students without QR codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->argument('count');

        $qrQuery = \App\Models\QRCode::whereNull('student_id')->where('is_assigned', false);
        $studentQuery = \App\Models\Student::doesntHave('qrCode');

        if ($count) {
            $qrQuery->limit($count);
        }

        $qrs = $qrQuery->get();
        $students = $studentQuery->limit($qrs->count())->get();

        if ($students->isEmpty() || $qrs->isEmpty()) {
            $this->info('No students or QR codes available for assignment.');
            return 0;
        }

        $bar = $this->output->createProgressBar(min($qrs->count(), $students->count()));
        $bar->start();

        foreach ($qrs as $i => $qr) {
            if (! isset($students[$i])) break;
            $student = $students[$i];

            $qr->student_id = $student->id;
            $qr->is_assigned = true;
            $qr->save();

            // Update student's qr_code_path for convenience
            $student->qr_code_path = $qr->qr_image_path;
            $student->save();

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Assigned QR codes to students.');
        return 0;
    }
}
