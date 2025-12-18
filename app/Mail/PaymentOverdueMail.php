<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentOverdueMail extends Mailable
{
    use SerializesModels;
    
    public $student;
    public $daysOverdue;

    public $monthNumber;

    /**
     * Create a new message instance.
     */
    public function __construct($student, $daysOverdue = 0, $monthNumber = 1)
    {
        $this->student = $student;
        $this->daysOverdue = $daysOverdue;
        $this->monthNumber = $monthNumber;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Urgent: Class Fee Payment Reminder - Action Required',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_overdue',
            with: [
                'studentName' => $this->student->first_name . ' ' . $this->student->last_name,
                'courseName' => $this->student->course->name ?? 'N/A',
                'centerName' => $this->student->center->name ?? 'N/A',
                'registrationDate' => $this->student->created_at->format('F d, Y'),
                'daysOverdue' => $this->daysOverdue,
                'monthNumber' => $this->monthNumber,
                'registrationNumber' => $this->student->registration_number,
            ],
        );
    }
}
