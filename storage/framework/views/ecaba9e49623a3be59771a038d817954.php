<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Professional Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .stat-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .table-row {
            transition: all 0.2s ease;
        }
        .table-row:hover {
            background-color: #f8fafc;
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
        .chart-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.25rem;
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold sidebar-text">Admin Portal</h1>
            </div>

            <nav class="space-y-2">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3 nav-text">Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.students.index')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('admin.students.index') ? 'active' : ''); ?>">
                    <i class="fas fa-user-graduate w-5"></i>
                    <span class="ml-3 nav-text">Students</span>
                </a>
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('admin.payments.index') ? 'active' : ''); ?>">
                    <i class="fas fa-credit-card w-5"></i>
                    <span class="ml-3 nav-text">Payments</span>
                </a>
                <a href="<?php echo e(route('admin.reports')); ?>" class="flex items-center py-2 px-4 nav-link <?php echo e(request()->routeIs('admin.reports') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="ml-3 nav-text">Reports</span>
                </a>
                <a href="#" class="flex items-center py-2 px-4 nav-link">
                    <i class="fas fa-cog w-5"></i>
                    <span class="ml-3 nav-text">Settings</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                    <p class="text-sm text-gray-600">Welcome back, <?php echo e(Auth::user()->name); ?></p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span class="notification-badge">5</span>
                        </button>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <div @click="open = !open" class="cursor-pointer flex items-center">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-primary-700 font-semibold"><?php echo e(substr(Auth::user()->name, 0, 2)); ?></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800"><?php echo e(Auth::user()->name); ?></p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </form>
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

    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Payment Trends Chart
            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
            const paymentChart = new Chart(paymentCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Payments Received',
                        data: [18500, 21200, 19800, 22400, 23900, 28700, 31200, 34800, 39200, 41200, 43800, 45230],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Course Distribution Chart
            const courseCtx = document.getElementById('courseChart').getContext('2d');
            const courseChart = new Chart(courseCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Web Development', 'Data Science', 'Graphic Design', 'Digital Marketing', 'Language Courses'],
                    datasets: [{
                        data: [35, 25, 15, 12, 13],
                        backgroundColor: [
                            '#0ea5e9',
                            '#3b82f6',
                            '#6366f1',
                            '#8b5cf6',
                            '#a855f7'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\Group Project\myproject\resources\views/layouts/Admin.blade.php ENDPATH**/ ?>