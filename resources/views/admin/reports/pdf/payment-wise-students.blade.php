<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment-wise Student Report - {{ now()->format('Y-m-d') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Landscape Optimized Styles with Larger Fonts */
        @page {
            size: landscape;
            margin: 1cm;
        }
        
        :root {
            --primary-blue: #2563eb;
            --light-blue: #eff6ff;
            --dark-blue: #1e40af;
            --success-green: #059669;
            --warning-yellow: #d97706;
            --danger-red: #dc2626;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-700: #374151;
            --gray-900: #111827;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 15px;
            color: var(--gray-900);
            font-size: 12px; /* Increased from 9px */
            background: #ffffff;
            width: 100%;
            min-height: 100vh;
            line-height: 1.5;
        }
        
        /* Landscape Container */
        .landscape-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: none;
            margin: 0 auto;
            gap: 15px;
        }
        
        /* Compact Header */
        .report-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 14px;
            border: 1px solid var(--gray-200);
            margin-bottom: 10px;
        }
        
        .header-left {
            flex: 1;
        }
        
        .header-right {
            text-align: right;
        }
        
        h1 {
            font-size: 24px; /* Increased from 20px */
            font-weight: 700;
            margin: 0 0 6px 0;
            color: var(--gray-900);
            letter-spacing: -0.5px;
        }
        
        .report-subtitle {
            font-size: 13px; /* Increased from 10px */
            color: var(--gray-600);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        /* Compact Statistics - Horizontal Layout */
        .stats-horizontal {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .stat-item {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            padding: 15px 18px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.2s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .stat-icon {
            width: 40px; /* Increased from 32px */
            height: 40px; /* Increased from 32px */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px; /* Added icon size */
        }
        
        .stat-icon.students { background: rgba(37, 99, 235, 0.1); color: var(--primary-blue); }
        .stat-icon.paid { background: rgba(5, 150, 105, 0.1); color: var(--success-green); }
        .stat-icon.due { background: rgba(217, 119, 6, 0.1); color: var(--warning-yellow); }
        .stat-icon.balance { background: rgba(124, 58, 237, 0.1); color: #7c3aed; }
        
        .stat-content {
            flex: 1;
            min-width: 0;
        }
        
        .stat-label {
            font-size: 11px; /* Increased from 9px */
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        
        .stat-value {
            font-size: 26px; /* Increased from 22px */
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1;
            margin: 0;
        }
        
        /* Compact Table - Optimized for Landscape */
        .table-container-compact {
            flex: 1;
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .table-header-compact {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .table-title {
            font-size: 18px; /* Increased from 14px */
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Table Layout for Landscape */
        .compact-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }
        
        .compact-table th {
            padding: 14px 16px; /* Increased padding */
            font-size: 11px; /* Increased from 8.5px */
            font-weight: 600;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 2px solid var(--gray-300);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        /* Column Widths for Landscape */
        .compact-table th:nth-child(1) { width: 18%; } /* Student Name */
        .compact-table th:nth-child(2) { width: 12%; } /* Course */
        .compact-table th:nth-child(3) { width: 12%; } /* Course Fee */
        .compact-table th:nth-child(4) { width: 12%; } /* Total Paid */
        .compact-table th:nth-child(5) { width: 12%; } /* Total Due */
        .compact-table th:nth-child(6) { width: 12%; } /* Balance */
        .compact-table th:nth-child(7) { width: 12%; } /* Status */
        
        .compact-table td {
            padding: 14px 16px; /* Increased from 10px 12px */
            font-size: 12px; /* Increased from 9px */
            color: var(--gray-900);
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
        }
        
        /* Compact table rows */
        tbody tr {
            transition: background-color 0.15s ease;
        }
        
        tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.02);
        }
        
        /* Student name compact styling */
        .student-name {
            font-weight: 600;
            color: var(--gray-900);
            line-height: 1.4;
            font-size: 12px; /* Added explicit font size */
        }
        
        .student-id {
            font-size: 10px; /* Increased from 8px */
            color: var(--gray-500);
            display: block;
            margin-top: 4px;
        }
        
        /* Currency values */
        .currency-value {
            font-family: 'Inter', monospace;
            font-weight: 600;
            font-size: 12px; /* Added font size */
        }
        
        .currency-positive {
            color: var(--success-green);
        }
        
        .currency-negative {
            color: var(--danger-red);
        }
        
        .currency-neutral {
            color: var(--gray-700);
        }
        
        /* Compact Status Badges */
        .status-badge-compact {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px; /* Increased padding */
            border-radius: 14px;
            font-size: 10.5px; /* Increased from 8.5px */
            font-weight: 600;
            line-height: 1.2;
        }
        
        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-overdue { background: #fee2e2; color: #7f1d1d; }
        .badge-overpaid { background: #dbeafe; color: #1e40af; }
        .badge-partial { background: #fef3c7; color: #92400e; }
        
        .status-dot {
            width: 8px; /* Increased from 6px */
            height: 8px; /* Increased from 6px */
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        .dot-paid { background: var(--success-green); }
        .dot-overdue { background: var(--danger-red); }
        .dot-overpaid { background: var(--primary-blue); }
        .dot-partial { background: var(--warning-yellow); }
        
        /* Footer */
        .compact-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px; /* Increased padding */
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-top: 1px solid var(--gray-200);
            font-size: 11px; /* Increased from 8.5px */
            color: var(--gray-600);
        }
        
        .footer-left, .footer-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Empty State for Landscape */
        .empty-state-compact {
            padding: 50px 20px; /* Increased padding */
            text-align: center;
            color: var(--gray-500);
        }
        
        .empty-state-compact i {
            font-size: 36px; /* Increased from 28px */
            margin-bottom: 12px;
            opacity: 0.4;
        }
        
        /* Icon sizes */
        .fa-arrow-down, .fa-arrow-up, .fa-equals, .fa-clock {
            font-size: 10px !important; /* Increased icon size */
        }
        
        /* Print Optimizations for Landscape */
        @media print {
            body {
                padding: 0;
                margin: 0;
                background: white;
                font-size: 11px; /* Increased for print */
            }
            
            .landscape-container {
                gap: 10px;
            }
            
            .report-header, .stat-item, .table-container-compact {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                break-inside: avoid;
            }
            
            .stat-item:hover {
                transform: none !important;
            }
            
            tbody tr:hover {
                background-color: transparent !important;
            }
            
            /* Ensure table fits in landscape */
            .compact-table {
                font-size: 11px; /* Increased for print */
            }
            
            .compact-table th,
            .compact-table td {
                padding: 10px 12px; /* Increased for print */
            }
            
            h1 {
                font-size: 22px; /* Slightly smaller for print */
            }
            
            .stat-value {
                font-size: 24px; /* Slightly smaller for print */
            }
        }
        
        /* Responsive adjustments for very wide screens */
        @media (min-width: 1400px) {
            body {
                font-size: 13px; /* Increased for wide screens */
                padding: 20px;
            }
            
            .compact-table {
                font-size: 13px; /* Increased for wide screens */
            }
            
            .stat-value {
                font-size: 28px; /* Increased for wide screens */
            }
            
            h1 {
                font-size: 26px; /* Increased for wide screens */
            }
        }
        
        /* Ensure no page breaks inside rows */
        tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        /* Improved readability for numbers */
        .text-right {
            text-align: right;
        }
        
        .text-left {
            text-align: left;
        }
        
        /* Larger margins for better readability */
        .mb-10 {
            margin-bottom: 20px;
        }
        
        /* Larger line height for better readability */
        .compact-table td, .compact-table th {
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="landscape-container">
        <!-- Compact Header -->
        <div class="report-header">
            <div class="header-left">
                <h1>Payment-wise Student Report</h1>
                <p class="report-subtitle">
                    <span><i class="fas fa-chart-line"></i> Comprehensive payment analysis</span>
                    <span><i class="fas fa-calendar-alt"></i> Generated: {{ now()->format('M d, Y h:i A') }}</span>
                </p>
            </div>
            <div class="header-right">
                <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(37, 99, 235, 0.1); padding: 8px 15px; border-radius: 10px;">
                    <i class="fas fa-file-pdf text-blue-600" style="font-size: 14px;"></i>
                    <span style="font-size: 11px; font-weight: 600; color: var(--gray-700);">LANDSCAPE REPORT</span>
                </div>
            </div>
        </div>

        <!-- Horizontal Statistics -->
        <div class="stats-horizontal">
            <div class="stat-item">
                <div class="stat-icon students">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Students</div>
                    <div class="stat-value">{{ $students->count() }}</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon paid">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Paid</div>
                    <div class="stat-value">Rs. {{ number_format($students->sum('total_paid'), 2) }}</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon due">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Due</div>
                    <div class="stat-value">Rs. {{ number_format($students->sum('total_due'), 2) }}</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon balance">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Overall Balance</div>
                    <div class="stat-value">Rs. {{ number_format($students->sum('balance'), 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Compact Table Container -->
        <div class="table-container-compact">
            <div class="table-header-compact">
                <h3 class="table-title">
                    <i class="fas fa-table"></i>
                    Student Payment Summary
                    <span style="font-size: 13px; color: var(--gray-600); margin-left: auto;">
                        {{ $students->count() }} records
                    </span>
                </h3>
            </div>
            
            <div style="overflow-x: auto; max-height: calc(100vh - 300px);">
                <table class="compact-table">
                    <thead>
                        <tr>
                            <th class="text-left">Student Details</th>
                            <th class="text-left">Course</th>
                            <th class="text-right">Course Fee</th>
                            <th class="text-right">Total Paid</th>
                            <th class="text-right">Total Due</th>
                            <th class="text-right">Balance</th>
                            <th class="text-left">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $data)
                        <tr>
                            <!-- Student Name -->
                            <td class="text-left">
                                <div class="student-name">
                                    {{ $data['student']->first_name }} {{ $data['student']->last_name }}
                                </div>
                                <span class="student-id">{{ $data['student']->registration_number }}</span>
                            </td>
                            
                            <!-- Course -->
                            <td class="text-left">
                                <div style="font-weight: 500; color: var(--gray-900);">
                                    {{ $data['student']->course->name ?? 'N/A' }}
                                </div>
                            </td>
                            
                            <!-- Course Fee -->
                            <td class="text-right">
                                <div class="currency-value currency-neutral">
                                    Rs. {{ number_format($data['total_course_fee'], 2) }}
                                </div>
                            </td>
                            
                            <!-- Total Paid -->
                            <td class="text-right">
                                <div class="currency-value currency-positive">
                                    <i class="fas fa-arrow-down"></i>
                                    Rs. {{ number_format($data['total_paid'], 2) }}
                                </div>
                            </td>
                            
                            <!-- Total Due -->
                            <td class="text-right">
                                <div class="currency-value" style="color: var(--warning-yellow);">
                                    <i class="fas fa-clock"></i>
                                    Rs. {{ number_format($data['total_due'], 2) }}
                                </div>
                            </td>
                            
                            <!-- Balance -->
                            <td class="text-right">
                                <div class="currency-value {{ $data['balance'] > 0 ? 'currency-negative' : 'currency-positive' }}">
                                    @if($data['balance'] > 0)
                                        <i class="fas fa-arrow-up"></i>
                                    @elseif($data['balance'] < 0)
                                        <i class="fas fa-arrow-down"></i>
                                    @else
                                        <i class="fas fa-equals"></i>
                                    @endif
                                    Rs. {{ number_format(abs($data['balance']), 2) }}
                                </div>
                            </td>
                            
                            <!-- Status -->
                            <td class="text-left">
                                @if($data['payment_status'] == 'paid')
                                    <div class="status-badge-compact badge-paid">
                                        <span class="status-dot dot-paid"></span>
                                        Paid
                                    </div>
                                @elseif($data['payment_status'] == 'overdue')
                                    <div class="status-badge-compact badge-overdue">
                                        <span class="status-dot dot-overdue"></span>
                                        Overdue
                                    </div>
                                @elseif($data['payment_status'] == 'overpaid')
                                    <div class="status-badge-compact badge-overpaid">
                                        <span class="status-dot dot-overpaid"></span>
                                        Overpaid
                                    </div>
                                @else
                                    <div class="status-badge-compact badge-partial">
                                        <span class="status-dot dot-partial"></span>
                                        {{ ucfirst($data['payment_status']) }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-state-compact">
                                <i class="fas fa-inbox"></i>
                                <div style="font-weight: 600; color: var(--gray-700); margin: 5px 0; font-size: 14px;">No student payment data found</div>
                                <div style="font-size: 12px;">There are no student payment records to display</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Compact Footer -->
            <div class="compact-footer">
                <div class="footer-left">
                    <i class="fas fa-info-circle" style="font-size: 13px;"></i>
                    <span>Total analyzed: {{ $students->count() }} students</span>
                </div>
                <div class="footer-right">
                    <i class="fas fa-print" style="font-size: 13px;"></i>
                    <span>Landscape Report • {{ now()->format('M d, Y h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>