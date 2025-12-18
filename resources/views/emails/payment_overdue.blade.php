<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Reminder</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 25px;
        }
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-box strong {
            color: #856404;
        }
        .info-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
            text-align: right;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .highlight {
            color: #dc3545;
            font-weight: 600;
        }
        .success {
            color: #28a745;
            font-weight: 600;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px 15px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>⚠️ Payment Reminder - Month {{ $monthNumber }}</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px;">Class Fee Payment Required</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $studentName }}</strong>,</p>

            <p>This is a reminder regarding your class fee payment for <strong style="background: #667eea; color: white; padding: 4px 12px; border-radius: 12px; font-size: 14px;">Month {{ $monthNumber }}</strong></p>

            <div class="alert-box">
                <strong>⏰ Payment Pending:</strong> You are currently in <span class="highlight">week 3 of Month {{ $monthNumber }}</span> ({{ $daysOverdue }} days since registration). We have not yet received your payment for this month.
            </div>

            <p>According to our records, you registered for the course on <strong>{{ $registrationDate }}</strong>. As per our policy, each month consists of <strong>4 weeks (28 days)</strong>, and payment should be completed by the end of week 3 to avoid service disruption.</p>

            <!-- Student Information -->
            <div class="info-box">
                <h3 style="margin-top: 0; color: #667eea;">📋 Your Registration Details</h3>
                <div class="info-row">
                    <span class="info-label">Registration Number:</span>
                    <span class="info-value">{{ $registrationNumber }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Course Name:</span>
                    <span class="info-value">{{ $courseName }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Center:</span>
                    <span class="info-value">{{ $centerName }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Registration Date:</span>
                    <span class="info-value">{{ $registrationDate }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Days Since Registration:</span>
                    <span class="info-value">{{ $daysOverdue }} days</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Current Month:</span>
                    <span class="info-value highlight">Month {{ $monthNumber }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value highlight">Not Paid for Month {{ $monthNumber }}</span>
                </div>
            </div>

            <h3 style="color: #667eea;">💳 How to Make Payment</h3>
            <p>Please visit our center or contact our reception to complete your <strong>Month {{ $monthNumber }}</strong> payment. You can make the payment through:</p>
            <ul>
                <li>Cash payment at the center</li>
                <li>Bank transfer</li>
                <li>Card payment at reception</li>
            </ul>

            <p style="text-align: center; margin: 30px 0;">
                <a href="tel:+94778778828" class="cta-button">📞 Contact Reception</a>
            </p>

            <div style="background-color: #e7f3ff; border-left: 4px solid #2196F3; padding: 15px; margin: 20px 0; border-radius: 5px;">
                <strong>ℹ️ Payment Policy:</strong><br>
                Each month consists of 4 weeks (28 days). You should complete your payment by the end of week 3 of each month to continue your classes without interruption. Timely payment ensures uninterrupted access to your classes and course materials. If you have already made the payment for Month {{ $monthNumber }}, please disregard this reminder or contact us with your payment proof.
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to reach out to us. We're here to help!</p>

            <p style="margin-top: 30px;">
                Best regards,<br>
                <strong>Innovior Institute of Technology</strong><br>
                <em>Your Learning Center</em>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 5px 0;">This is an automated reminder email.</p>
            <p style="margin: 5px 0;">If you have any concerns, please contact us immediately.</p>
            <p style="margin: 15px 0 5px 0; color: #999;">
                © {{ date('Y') }} Student Management System. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
