<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details - {{ $qr->code }}</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>QR: {{ $qr->code }}</h1>

    @if (! $student)
        <div class="alert alert-warning">This QR code is not assigned to any student.</div>
        <div>
            <img src="{{ asset($qr->qr_image_path) }}" alt="QR" style="max-width:300px;">
        </div>
    @else

    <div class="card mb-3">
        <div class="card-body">
            <h2>{{ $student->full_name }} ({{ $student->registration_number }})</h2>
            <p><strong>Course:</strong> {{ optional($student->course)->name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Phone:</strong> {{ $student->student_phone }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Payments</div>
                <div class="card-body">
                    <p><strong>Total Paid:</strong> {{ number_format($totalPaid, 2) }}</p>
                    <table class="table table-sm">
                        <thead><tr><th>Date</th><th>Amount</th><th>Method</th></tr></thead>
                        <tbody>
                        @foreach($payments as $p)
                            <tr>
                                <td>{{ $p->payment_date ? \Carbon\Carbon::parse($p->payment_date)->format('Y-m-d') : '-' }}</td>
                                <td>{{ number_format($p->amount, 2) }}</td>
                                <td>{{ $p->payment_method }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Attendance</div>
                <div class="card-body">
                    @if($latestAttendance)
                        <p><strong>Last:</strong> {{ $latestAttendance->attended_at ? \Carbon\Carbon::parse($latestAttendance->attended_at)->format('Y-m-d H:i') : '-' }} ({{ $latestAttendance->status }})</p>
                        <p>{{ $latestAttendance->notes }}</p>
                    @else
                        <p>No attendance records yet.</p>
                    @endif

                    <form method="POST" action="{{ route('qr.attendance', $qr->code) }}">
                        @csrf
                        <div class="form-group">
                            <label for="status">Mark as</label>
                            <select name="status" id="status" class="form-control">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="late">Late</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes (optional)</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-primary mt-2">Mark Attendance</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">QR Image</div>
                <div class="card-body">
                    <img src="{{ asset($qr->qr_image_path) }}" alt="QR" style="max-width:250px;">
                </div>
            </div>
        </div>
    </div>
</div>
    @endif
</body>
</html>
