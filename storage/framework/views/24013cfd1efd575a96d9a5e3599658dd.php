<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        <style>
            /* CSS Variables for consistent theming */
            :root {
                --primary-color: #6366f1;
                --primary-hover: #4f46e5;
                --secondary-color: #f3f4f6;
                --text-color: #1f2937;
                --text-light: #6b7280;
                --error-color: #ef4444;
                --success-color: #10b981;
                --border-radius: 12px;
                --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                --transition: all 0.3s ease;
            }

            /* Base Styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Figtree', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
                font-family: 'Figtree', sans-serif;
            }

            /* Login Container */
            .auth-container {
                background: white;
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                width: 100%;
                max-width: 440px;
                overflow: hidden;
                position: relative;
                transition: var(--transition);
            }

            .auth-container:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            /* Header Section */
            .auth-header {
                background: linear-gradient(to right, var(--primary-color), var(--primary-hover));
                color: white;
                text-align: center;
                padding: 30px 20px;
            }

            .auth-header h1 {
                font-size: 28px;
                margin-bottom: 10px;
                font-weight: 600;
            }

            .auth-header p {
                font-size: 16px;
                opacity: 0.9;
            }

            /* Form Section */
            .auth-form {
                padding: 30px;
            }

            .form-group {
                margin-bottom: 20px;
                position: relative;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: var(--text-color);
            }

            .input-with-icon {
                position: relative;
            }

            .input-icon {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--text-light);
            }

            .form-control {
                width: 100%;
                padding: 15px 15px 15px 45px;
                border: 2px solid #e5e7eb;
                border-radius: var(--border-radius);
                font-size: 16px;
                transition: var(--transition);
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
                outline: none;
            }

            .toggle-password {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: var(--text-light);
            }

            /* Remember Me & Forgot Password */
            .remember-forgot {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .remember-me {
                display: flex;
                align-items: center;
            }

            .remember-me input {
                margin-right: 8px;
                accent-color: var(--primary-color);
            }

            .forgot-password {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
                transition: var(--transition);
            }

            .forgot-password:hover {
                color: var(--primary-hover);
                text-decoration: underline;
            }

            /* Submit Button */
            .auth-button {
                width: 100%;
                padding: 15px;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: var(--border-radius);
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: var(--transition);
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .auth-button:hover {
                background: var(--primary-hover);
            }

            .button-spinner {
                display: none;
                margin-left: 10px;
            }

            /* Error Messages */
            .error-message {
                color: var(--error-color);
                font-size: 14px;
                margin-top: 5px;
                display: flex;
                align-items: center;
            }

            .error-message i {
                margin-right: 5px;
            }

            /* Footer */
            .auth-footer {
                text-align: center;
                padding: 20px;
                border-top: 1px solid #e5e7eb;
                color: var(--text-light);
                font-size: 14px;
            }

            .auth-footer a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
            }

            /* Responsive Design */
            @media (max-width: 480px) {
                .auth-container {
                    max-width: 100%;
                }

                .auth-form {
                    padding: 20px;
                }

                .remember-forgot {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .forgot-password {
                    margin-top: 10px;
                }
            }

            /* Animation for session status */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .session-status {
                animation: fadeIn 0.5s ease;
            }

            /* Application logo styling */
            .app-logo-container {
                text-align: center;
                margin-bottom: 20px;
            }

            .app-logo {
                width: 80px;
                height: 80px;
            }
        </style>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-header">
                <div class="app-logo-container">
                    <a href="/">
                        <img src="<?php echo e(asset('images/1.jpg')); ?>" alt="Logo" class="app-logo">
                    </a>
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to continue to your account</p>
            </div>

            <div class="auth-form">
                <?php echo e($slot); ?>

            </div>

            <div class="auth-footer">
                <?php if(Route::has('register')): ?>
                    Don't have an account? <a href="<?php echo e(route('register')); ?>">Sign up</a>
                <?php endif; ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password visibility toggler
                const togglePassword = document.querySelector('.toggle-password');
                const passwordInput = document.getElementById('password');

                if (togglePassword && passwordInput) {
                    togglePassword.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);

                        // Toggle eye icon
                        const eyeIcon = this.querySelector('i');
                        eyeIcon.classList.toggle('fa-eye');
                        eyeIcon.classList.toggle('fa-eye-slash');
                    });
                }

                // Form submission handler
                const loginForm = document.getElementById('loginForm');
                const loginButton = document.querySelector('.auth-button');
                const buttonSpinner = document.querySelector('.button-spinner');

                if (loginForm && loginButton && buttonSpinner) {
                    loginForm.addEventListener('submit', function() {
                        // Show loading spinner
                        loginButton.disabled = true;
                        buttonSpinner.style.display = 'inline-block';
                        loginButton.innerHTML = 'Logging in ' + buttonSpinner.outerHTML;
                    });
                }

                // Input validation styling
                const inputs = document.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    // Add focus effect
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });

                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('focused');
                        // Validate on blur
                        if (this.value.trim() !== '') {
                            this.classList.add('has-value');
                        } else {
                            this.classList.remove('has-value');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
<?php /**PATH G:\Projects\innovior info\66\Student Management System\resources\views/layouts/guest.blade.php ENDPATH**/ ?>