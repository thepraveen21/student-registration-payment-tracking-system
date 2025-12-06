
<!DOCTYPE html>
<html>
<head>
    <title>Overdue Payment Reminder</title>
</head>
<body>
    <p>Dear {{ $student->name }},</p>
    <p>This is a reminder that your monthly payment for the course "{{ $student->course->name }}" is overdue.</p>
    <p>Please make the payment as soon as possible to avoid any disruption to your studies.</p>
    <p>Thank you,</p>
    <p>The Institute</p>
</body>
</html>
