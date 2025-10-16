<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Professional Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-container {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .form-container:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }
        .input-field {
            transition: all 0.2s ease;
            padding-left: 2.75rem !important; /* Ensure text doesn't overlap with icon */
            padding-right: 2.75rem !important; /* Ensure text doesn't overlap with toggle */
        }
        .input-field:focus {
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
        }
        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.2s ease;
            z-index: 10; /* Ensure icon stays above input field */
            pointer-events: none; /* Make sure clicks go through to input */
        }
        .input-with-icon:focus-within .input-icon {
            color: #0ea5e9;
        }
        .btn-primary {
            transition: all 0.3s ease;
            background: linear-gradient(to right, #0ea5e9, #0284c7);
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #0284c7, #0369a1);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(2, 132, 199, 0.25);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .password-toggle {
            cursor: pointer;
            transition: color 0.2s ease;
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10; /* Ensure toggle stays above input field */
        }
        .password-toggle:hover {
            color: #0ea5e9;
        }
        .button-spinner {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .loading .button-spinner {
            opacity: 1;
        }
        .loading .button-text {
            opacity: 0.7;
        }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }
        .session-status {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .session-status.success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .session-status.error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .checkbox-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .checkbox-container input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .checkmark {
            height: 1.25rem;
            width: 1.25rem;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .checkbox-container input[type="checkbox"]:checked ~ .checkmark {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
        }
        .checkmark:after {
            content: "";
            display: none;
            width: 0.3125rem;
            height: 0.625rem;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            position: relative;
            top: -1px;
        }
        .checkbox-container input[type="checkbox"]:checked ~ .checkmark:after {
            display: block;
        }
        /* Fix for input field text overlapping icons */
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-container .input-field {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-md w-full form-container bg-white rounded-xl overflow-hidden p-8">
        <!-- Header Section -->
        <div class="text-center mb-8 opacity-0 animate-fade-in-up">
            <div class="mx-auto w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mb-4">
                <img src="<?php echo e(asset('images/1.jpg')); ?>" alt="Logo" class="app-logo">
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
            <p class="text-gray-600 mt-2">Sign in to your account</p>
        </div>

        <!-- Session Status -->
        <?php if(session('status')): ?>
            <div class="session-status success mb-5">
                <i class="fas fa-check-circle mr-2"></i>
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
            <?php echo csrf_field(); ?>
            <!-- Email Address -->
            <div class="mb-5 opacity-0 animate-fade-in-up animate-delay-2">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="input-container">
                    <i class="input-icon fas fa-envelope"></i>
                    <input id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="Enter your email"
                        class="input-field w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message mt-2 text-sm text-red-600"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div class="mb-5 opacity-0 animate-fade-in-up animate-delay-3">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="input-container">
                    <i class="input-icon fas fa-lock"></i>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"
                        class="input-field w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    <span class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message mt-2 text-sm text-red-600"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6 opacity-0 animate-fade-in-up animate-delay-4">
                <label class="checkbox-container text-sm text-gray-600 flex items-center">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span class="checkmark mr-2"></span>
                    Remember me
                </label>

                <?php if(Route::has('password.request')): ?>
                    <a class="text-sm text-primary-600 font-medium hover:underline" href="<?php echo e(route('password.request')); ?>">
                        Forgot password?
                    </a>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="opacity-0 animate-fade-in-up animate-delay-5">
                <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-md relative">
                    <span class="button-text">Log in</span>
                    <div class="button-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>
            </div>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center opacity-0 animate-fade-in-up animate-delay-5">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="<?php echo e(route('register')); ?>" class="text-primary-600 font-semibold hover:underline">
                        Sign up
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        // Password visibility toggle
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Update icon
            const icon = passwordField.parentNode.querySelector('.password-toggle i');
            if (type === 'text') {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Add animation classes to elements after page load
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animate-fade-in-up');
            animatedElements.forEach(element => {
                element.classList.remove('opacity-0');
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Projects\Laravel\New folder\Student Management System\resources\views/auth/login.blade.php ENDPATH**/ ?>