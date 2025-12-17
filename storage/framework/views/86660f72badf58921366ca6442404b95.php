<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Student Registration & Payment Tracking</title>

    <style>
        /* Animated Gradient Background */
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(-45deg, #0f172a, #1e3a8a, #2563eb, #1e40af);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: white;
            text-align: center;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container */
        .container {
            max-width: 900px;
            width: 90%;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        p.subtitle {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.85;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }
        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s, background 0.3s;
            font-size: 1rem;
        }
        .btn-login {
            background: #ffda44;
            color: #222;
        }
        .btn-login:hover {
            background: #ffe366;
            transform: scale(1.05);
        }
        .btn-register {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .btn-register:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        /* Feature cards */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .feature {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        .feature:hover {
            transform: translateY(-5px);
        }
        .feature h3 {
            margin-bottom: 8px;
            font-size: 1.2rem;
        }
        .footer {
            margin-top: 25px;
            font-size: 0.8rem;
            opacity: 0.7;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logo -->
        <img src="<?php echo e(asset('images/1.jpg')); ?>" alt="Logo" style="width:90px;height:90px;border-radius:50%;border:3px solid white;box-shadow:0 4px 10px rgba(0,0,0,0.3);margin-bottom:20px;">

        <!-- Title & Subtitle -->
        <h1>Welcome to <span style="color:#ffda44;">Student Registration & Payment Tracking</span></h1>
        <p class="subtitle">Manage students, track payments, and send smart notifications — everything you need to run your institute efficiently.</p>

        <!-- Buttons -->
        <div class="btn-group">
            <a href="<?php echo e(route('login')); ?>" class="btn btn-login">🔑 Login</a>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-register">📝 Register</a>
        </div>

        <!-- Features -->
        <div class="features">
            <div class="feature">
                <h3>📋 Easy Registration</h3>
                <p>Register students instantly and generate a unique QR code for identification.</p>
            </div>
            <div class="feature">
                <h3>💰 Payment Tracking</h3>
                <p>View payment history, record new payments, and keep finances transparent.</p>
            </div>
            <div class="feature">
                <h3>📢 Smart Notifications</h3>
                <p>Notify students and parents about overdue payments automatically.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> Student Registration & Payment Tracking System • All Rights Reserved
        </div>
    </div>

</body>
</html>
<?php /**PATH E:\Project\Student Management System\resources\views/welcome.blade.php ENDPATH**/ ?>