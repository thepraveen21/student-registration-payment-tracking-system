<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Reception Dashboard'); ?> | Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>


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
            overflow-x: hidden;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0c4a6e 0%, #0369a1 50%, #0284c7 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }
        .main-content {
            width: calc(100% - 260px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }
        .nav-link {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .nav-link:hover, .nav-link.active {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 0.5rem;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background-color: #38bdf8;
            border-radius: 0 4px 4px 0;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 100;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .mobile-menu-btn:hover {
            transform: scale(1.05);
        }
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            backdrop-filter: blur(4px);
        }
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                height: 100vh;
                top: 0;
                left: 0;
                z-index: 50;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-content {
                width: 100%;
                margin-left: 0;
            }
            .mobile-menu-btn {
                display: block;
            }
            .mobile-overlay.active {
                display: block;
            }
        }
        @media (min-width: 1025px) {
            .sidebar {
                transform: translateX(0) !important;
            }
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #0ea5e9 0%, #0284c7 100%);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #0284c7 0%, #0369a1 100%);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars text-lg"></i>
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar text-white p-4 fixed h-full" id="sidebar">
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
        <div class="main-content ml-0 lg:ml-64">
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

    <!-- Mobile Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            function toggleMobileMenu() {
                sidebar.classList.toggle('mobile-open');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
            }
            
            mobileMenuBtn.addEventListener('click', toggleMobileMenu);
            mobileOverlay.addEventListener('click', toggleMobileMenu);
            
            // Close mobile menu when clicking on nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        toggleMobileMenu();
                    }
                });
            });
            
            // Close menu on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                    toggleMobileMenu();
                }
            });
            
            // Update active nav link based on current URL
            function updateActiveNav() {
                const currentPath = window.location.pathname;
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.href === window.location.href || 
                        (currentPath !== '/' && link.href.includes(currentPath) && currentPath.length > 1)) {
                        link.classList.add('active');
                    }
                });
            }
            
            updateActiveNav();
            
            // Smooth scroll to top on page navigation
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/layouts/reception.blade.php ENDPATH**/ ?>