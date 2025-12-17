<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> | Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        }
                    }
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
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
        }
        .stat-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
        }
        .table-row {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .table-row:hover {
            background-color: #f1f5f9;
            transform: translateX(4px);
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
        .chart-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        .user-avatar {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            box-shadow: 0 4px 6px rgba(14, 165, 233, 0.2);
        }
        .sidebar-logo {
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        .page-transition {
            animation: fade-in 0.5s ease-in-out;
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
        <div class="sidebar text-white p-6 fixed h-full" id="sidebar">
            <div class="flex items-center justify-between mb-10 mt-2">
                <div class="flex items-center">
                    <div class="sidebar-logo w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">Admin Portal</h1>
                        <p class="text-xs text-primary-200 mt-1">Administration Panel</p>
                    </div>
                </div>
            </div>

            <nav class="space-y-2">
                <?php
                    $currentRoute = request()->route()->getName();
                ?>
                
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="flex items-center py-3 px-4 nav-link <?php echo e(str_starts_with($currentRoute, 'dashboard') ? 'active' : ''); ?>">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-primary-200"></i>
                    </div>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('admin.students.index')); ?>" 
                   class="flex items-center py-3 px-4 nav-link <?php echo e(str_contains($currentRoute, 'students') ? 'active' : ''); ?>">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="fas fa-user-graduate text-primary-200"></i>
                    </div>
                    <span class="ml-3 font-medium">Students</span>
                </a>
                
                <a href="<?php echo e(route('admin.payments.index')); ?>" 
                   class="flex items-center py-3 px-4 nav-link <?php echo e(str_contains($currentRoute, 'payments') ? 'active' : ''); ?>">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="fas fa-credit-card text-primary-200"></i>
                    </div>
                    <span class="ml-3 font-medium">Payments</span>
                </a>
                
                <a href="<?php echo e(route('admin.reports.index')); ?>" 
                   class="flex items-center py-3 px-4 nav-link <?php echo e(str_contains($currentRoute, 'reports') ? 'active' : ''); ?>">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-primary-200"></i>
                    </div>
                    <span class="ml-3 font-medium">Reports</span>
                </a>
                
                <a href="<?php echo e(route('admin.settings.index')); ?>" 
                   class="flex items-center py-3 px-4 nav-link <?php echo e(str_contains($currentRoute, 'settings') ? 'active' : ''); ?>">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="fas fa-cog text-primary-200"></i>
                    </div>
                    <span class="ml-3 font-medium">Settings</span>
                </a>
                
                <div class="pt-8 mt-8 border-t border-primary-700">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <a href="<?php echo e(route('logout')); ?>"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="flex items-center py-3 px-4 nav-link hover:bg-red-500/10 text-red-200 hover:text-red-100">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span class="ml-3 font-medium">Logout</span>
                        </a>
                    </form>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="bg-primary-800/30 rounded-lg p-4 border border-primary-700/30">
                    <div class="flex items-center">
                        <div class="user-avatar w-10 h-10 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-semibold"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?></span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-primary-200">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content ml-0 lg:ml-64">
           <!-- Top Navigation -->
<header class="bg-white shadow-sm py-4 px-6 lg:px-8 border-b border-gray-100 sticky top-0 z-30">
    <div class="flex justify-between items-center">
        <!-- Left Section -->
        <div class="flex items-center">
            <div class="hidden lg:block">
                <h2 class="text-xl font-semibold text-gray-800"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                <p class="text-sm text-gray-600"><?php echo $__env->yieldContent('page-description', 'Welcome back, Admin'); ?></p>
            </div>
            <div class="lg:hidden">
                <h2 class="text-lg font-semibold text-gray-800">Dashboard</h2>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <?php
                    // Provided by AppServiceProvider view composer:
                    // - $pendingAdminNotifications
                    // - $pendingAdminCount
                    $pending = $pendingAdminNotifications ?? collect();
                    $pendingCount = $pendingAdminCount ?? 0;
                ?>

                <button @click="open = !open" class="p-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 group relative">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-600 text-lg group-hover:text-primary-600 transition-colors"></i>
                        <?php if($pendingCount > 0): ?>
                            <span class="notification-badge bg-gradient-to-r from-red-500 to-red-600 text-white shadow-sm"><?php echo e($pendingCount); ?></span>
                        <?php endif; ?>
                    </div>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-3 w-96 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden z-50">
                    <div class="p-3 border-b">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-semibold">Notifications</h4>
                            <span class="text-xs text-gray-500"><?php echo e($pendingCount); ?> pending</span>
                        </div>
                    </div>

                    <div class="max-h-72 overflow-y-auto">
                        <?php $__empty_1 = true; $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $d = $note->data; ?>
                            <div class="p-3 border-b hover:bg-gray-50">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <div class="text-sm font-medium"><?php echo e($d['message'] ?? ($d['user_name'] ?? 'New user')); ?></div>
                                        <div class="text-xs text-gray-500 mt-1"><?php echo e($d['user_name'] ?? ''); ?> — <?php echo e(ucfirst($d['role'] ?? '')); ?></div>
                                        <div class="text-xs text-gray-400 mt-1"><?php echo e($note->created_at->diffForHumans()); ?></div>
                                    </div>
                                    <div class="ml-3 flex items-center space-x-2">
                                        <form method="POST" action="<?php echo e(route('admin.users.approve', ['user' => $d['user_id']])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="px-3 py-1 text-xs bg-green-600 text-white rounded-md">Accept</button>
                                        </form>
                                        <form method="POST" action="<?php echo e(route('admin.users.reject', ['user' => $d['user_id']])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="px-3 py-1 text-xs bg-red-600 text-white rounded-md">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-4 text-sm text-gray-600">No notifications</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="hidden lg:flex items-center space-x-3">
                <a href="<?php echo e(route('admin.students.create')); ?>" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-blue-600 hover:from-primary-600 hover:to-blue-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2.5 text-sm"></i>
                    New Student
                </a>
                <a href="<?php echo e(route('admin.payments.create')); ?>" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-credit-card mr-2.5 text-sm"></i>
                    Record Payment
                </a>
            </div>

            <!-- Mobile Quick Actions -->
            <div class="lg:hidden flex items-center space-x-2">
                <a href="<?php echo e(route('admin.students.create')); ?>" 
                   class="inline-flex items-center p-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm rounded-lg transition-colors duration-200">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="<?php echo e(route('admin.payments.create')); ?>" 
                   class="inline-flex items-center p-2.5 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-colors duration-200">
                    <i class="fas fa-credit-card"></i>
                </a>
            </div>
        </div>
    </div>
</header>

            <!-- Main Content Area -->
            <main class="p-4 lg:p-6 page-transition">
                <!-- Breadcrumb -->
                <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm">
                            <li>
                                <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-home mr-1"></i>
                                    Home
                                </a>
                            </li>
                            <?php echo $__env->yieldContent('breadcrumb'); ?>
                        </ol>
                    </nav>
                <?php endif; ?>

                <!-- Success/Error Messages -->
                <?php if(session('success')): ?>
                    <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm animate-fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg shadow-sm animate-fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Page Content -->
                <div class="animate-fade-in">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="text-sm text-gray-600 mb-4 lg:mb-0">
                        &copy; <?php echo e(date('Y')); ?> Student Management System. All rights reserved.
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span>v1.0.0</span>
                        <span class="hidden lg:inline">|</span>
                        <span><?php echo e(now()->format('F d, Y')); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

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

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH G:\Projects\innovior info\66\Student Management System\resources\views/layouts/admin.blade.php ENDPATH**/ ?>