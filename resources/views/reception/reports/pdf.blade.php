<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Matrix Report</title>
    <style>
        @page {
            size: landscape;
            margin: 15px;
        }
        
        body { 
            font-family: "DejaVu Sans", Arial, sans-serif; 
            font-size: 10px;
            margin: 0;
            padding: 10px;
        }
        
        h1 { 
            font-size: 14px; 
            margin-bottom: 10px;
            page-break-before: avoid;
        }
        
        h2 { 
            font-size: 12px; 
            margin: 10px 0 5px 0;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 4px 2px; 
            text-align: left;
            font-size: 9px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        
        /* Fixed column widths for better control */
        .col-name { width: 12%; }
        .col-course { width: 12%; }
        .col-center { width: 12%; }
        .col-week { width: 2.5%; }  /* For week columns */
        .col-percent { width: 6%; }
        .col-payment-student { width: 30%; }
        .col-payment-center { width: 40%; }
        .col-payment-amount { width: 20%; }
        
        .payment-row td {
            padding: 3px 2px;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Attendance status styling */
        .present { 
            color: green; 
            font-weight: bold;
        }
        
        .absent { 
            color: red; 
            font-weight: bold;
        }
        
        /* Page break handling */
        .page-break { 
            page-break-before: always; 
            margin-top: 20px;
        }
        
        /* Shrink font for weeks if needed */
        .week-cell {
            font-size: 8px;
            padding: 2px 1px;
        }
        
        /* Compact layout for attendance table */
        .compact-table {
            margin: 0;
            border-spacing: 0;
        }
        
        /* Ensure tables don't overflow */
        .table-container {
            overflow-x: auto;
            width: 100%;
        }
        
        /* Print-specific adjustments */
        @media print {
            body {
                margin: 0.5cm;
                padding: 0;
            }
            
            table {
                page-break-inside: avoid;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <h1>Attendance Matrix Report</h1>
    
    <div class="table-container">
        <table class="compact-table">
            <thead>
                <tr>
                    <th class="col-name">Student Name</th>
                    <th class="col-course">Course</th>
                    <th class="col-center">Center</th>
                    @for($w = 1; $w <= 16; $w++)
                        <th class="col-week week-cell">W{{ $w }}</th>
                    @endfor
                    <th class="col-percent">Presence %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td class="col-name">{{ $student->name }}</td>
                        <td class="col-course">{{ $student->course->name ?? 'N/A' }}</td>
                        <td class="col-center">{{ $student->center->name ?? 'N/A' }}</td>
                        @php
                            $row = $attendanceMatrix[$student->id] ?? [];
                        @endphp
                        @for($i = 0; $i < 16; $i++)
                            @php
                                $attended = $row[$i]['attended'] ?? false;
                            @endphp
                            <td class="col-week week-cell text-center">
                                @if($attended)
                                    <span class="present">P</span>
                                @else
                                    <span class="absent">A</span>
                                @endif
                            </td>
                        @endfor
                        <td class="col-percent text-center">{{ ($stats[$student->id]['percent'] ?? 0) . '%' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <h1>Monthly Payment Report</h1>
    
    @forelse($paymentReports as $month => $payments)
        @php
            $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
            $monthTotal = $payments->sum('amount');
        @endphp
        
        <h2>{{ $monthLabel }} - Total: Rs. {{ number_format($monthTotal, 2) }}</h2>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="col-payment-student">Student</th>
                        <th class="col-payment-center">Center</th>
                        <th class="col-payment-amount">Payment (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $row)
                        <tr class="payment-row">
                            <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                            <td>{{ $row->center_name ?? 'N/A' }}</td>
                            <td class="text-right">{{ number_format($row->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(!$loop->last)
            <div style="margin-bottom: 20px;"></div>
        @endif
    @empty
        <p>No payment records found.</p>
    @endforelse
</body>
</html>