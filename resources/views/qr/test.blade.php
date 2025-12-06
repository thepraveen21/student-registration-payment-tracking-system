<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Test Page</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
<div class="container">
    <h1>QR Code Test Page</h1>
    <p class="alert alert-info">
        This is a test page to demonstrate QR code scanning. In production, you would scan these with a mobile device.
    </p>

    <div class="row">
        @foreach($qrcodes as $qr)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5>QR Code: {{ $qr->code }}</h5>
                        @if($qr->student)
                            <p><strong>Assigned to:</strong> {{ $qr->student->full_name }}</p>
                            <p><strong>Reg #:</strong> {{ $qr->student->registration_number }}</p>
                        @else
                            <p class="text-warning">Not assigned</p>
                        @endif
                        <img src="{{ asset($qr->qr_image_path) }}" alt="QR Code" style="max-width: 200px"><br>
                        <a href="{{ route('qr.show', $qr->code) }}" class="btn btn-primary mt-2">
                            Test Scan
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>