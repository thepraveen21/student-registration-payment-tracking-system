<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentPay - Payment Control System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #6f42c1;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light: #f8f9fc;
            --dark: #5a5c69;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.65rem;
        }

        .navbar-brand span {
            color: var(--primary);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
        }

        .stat-card {
            border-left: 4px solid;
            border-radius: 5px;
        }

        .stat-card.primary { border-left-color: var(--primary); }
        .stat-card.success { border-left-color: var(--success); }
        .stat-card.warning { border-left-color: var(--warning); }
        .stat-card.danger { border-left-color: var(--danger); }

        .dashboard-icon {
            font-size: 2rem;
            opacity: 0.3;
            position: absolute;
            right: 1rem;
            top: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #3a5fc8;
            border-color: #3a5fc8;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: linear-gradient(180deg, var(--primary) 10%, var(--secondary) 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar .nav-item { margin-bottom: 0.25rem; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); padding: 0.75rem 1rem; }
        .sidebar .nav-link:hover { color: #fff; }
        .sidebar .nav-link.active { color: #fff; font-weight: 600; }

        .sidebar-heading {
            color: rgba(255, 255, 255, 0.4);
            padding: 0 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .content-header {
            border-bottom: 1px solid #e3e6f0;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .recent-payments { font-size: 0.9rem; }
        .recent-payments .badge { font-weight: 500; }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('reception.dashboard')); ?>">
                <i class="fas fa-graduation-cap me-2"></i>Student<span>Pay</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge bg-danger badge-counter">3+</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge bg-danger badge-counter">7</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small">Reception User</span>
                            <img class="img-profile rounded-circle" src="https://via.placeholder.com/40" alt="Profile">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 d-none d-md-block sidebar py-3">
                <div class="nav flex-column">
                    <div class="nav-item">
                        <a class="nav-link active" href="<?php echo e(route('reception.dashboard')); ?>">
                            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="sidebar-heading mt-3">Interface</div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reception.students.index')); ?>">
                            <i class="fas fa-fw fa-user-graduate me-2"></i>
                            <span>Students</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reception.payments.index')); ?>">
                            <i class="fas fa-fw fa-money-bill-wave me-2"></i>
                            <span>Payments</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reception.invoices.index')); ?>">
                            <i class="fas fa-fw fa-file-invoice me-2"></i>
                            <span>Invoices</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reception.reports.index')); ?>">
                            <i class="fas fa-fw fa-chart-bar me-2"></i>
                            <span>Reports</span>
                        </a>
                    </div>
                    <div class="sidebar-heading mt-3">Admin</div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reception.settings')); ?>">
                            <i class="fas fa-fw fa-cog me-2"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reception.users.index')); ?>">
                            <i class="fas fa-fw fa-users me-2"></i>
                            <span>User Management</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <a href="#" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-fw fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
<?php /**PATH C:\Users\User\Desktop\Group Project\myproject\resources\views/Reception.blade.php ENDPATH**/ ?>