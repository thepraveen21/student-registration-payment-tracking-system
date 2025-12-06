<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Reception Dashboard'); ?> | Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

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
                }
            }
        }
    </script>
    <style type="text/css">
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, #0ea5e9, #0284c7);
            transition: all 0.3s ease;
        }
        .main-content {
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }
        .nav-link {
            transition: all 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            .main-content {
                width: calc(100% - 70px);
            }
            .sidebar .nav-text {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar text-white p-4 fixed h-full">
            <div class="flex items-center justify-center mb-8 mt-2">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-user-shield text-primary-600 text-xl"></i>
                </div>
                <h1 class="text-xl font-bold sidebar-text">Reception</h1>
            </div>

            <nav class="space-y-2">
                <a href="<?php echo e(route('reception.dashboard')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('reception.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3 nav-text">Dashboard</span>
                </a>
                <a href="<?php echo e(route('reception.students.index')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('reception.students.*') ? 'active' : ''); ?>">
                    <i class="fas fa-user-graduate w-5"></i>
                    <span class="ml-3 nav-text">Students</span>
                </a>
                <a href="<?php echo e(route('reception.payments.index')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('reception.payments.*') ? 'active' : ''); ?>">
                    <i class="fas fa-credit-card w-5"></i>
                    <span class="ml-3 nav-text">Payments</span>
                </a>
                <a href="<?php echo e(route('reception.attendance.index')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('reception.attendance.*') ? 'active' : ''); ?>">
                    <i class="fas fa-user-check w-5"></i>
                    <span class="ml-3 nav-text">Attendance</span>
                </a>
                <a href="<?php echo e(route('reception.qrcodes.manage')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('reception.qrcodes.*') ? 'active' : ''); ?>">
                    <i class="fas fa-qrcode w-5"></i>
                    <span class="ml-3 nav-text">QR Codes</span>
                </a>
                <a href="<?php echo e(route('reception.schedule.index')); ?>" class="flex items-center py-2 px-4 nav-link">
                    <i class="fas fa-calendar-alt w-5"></i>
                    <span class="ml-3 nav-text">Schedule</span>
                </a>
                <a href="<?php echo e(route('reception.reports.index')); ?>" class="flex items-center py-2 px-4 nav-link">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="ml-3 nav-text">Reports</span>
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center py-2 px-4 nav-link">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="ml-3 nav-text">Logout</span>
                    </a>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800"><?php echo $__env->yieldContent('header', 'Dashboard'); ?></h2>
                    <p class="text-sm text-gray-600">Reception Dashboard</p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-2">
                            <span class="text-primary-700 font-semibold"><?php echo e(substr(Auth::user()->name, 0, 2)); ?></span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-gray-500">Receptionist</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Dell\Desktop\008\Student Management System\resources\views/layouts/reception.blade.php ENDPATH**/ ?>