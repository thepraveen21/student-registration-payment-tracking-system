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
            <a class="navbar-brand" href="{{ route('reception.dashboard') }}">
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
                        <a class="nav-link active" href="{{ route('reception.dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="sidebar-heading mt-3">Interface</div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('reception.students.index') }}">
                            <i class="fas fa-fw fa-user-graduate me-2"></i>
                            <span>Students</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('reception.payments.index') }}">
                            <i class="fas fa-fw fa-money-bill-wave me-2"></i>
                            <span>Payments</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('reception.invoices.index') }}">
                            <i class="fas fa-fw fa-file-invoice me-2"></i>
                            <span>Invoices</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('reception.reports.index') }}">
                            <i class="fas fa-fw fa-chart-bar me-2"></i>
                            <span>Reports</span>
                        </a>
                    </div>
                    <div class="sidebar-heading mt-3">Admin</div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('reception.settings') }}">
                            <i class="fas fa-fw fa-cog me-2"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-fw fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9">
                <div class="content-header">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Reception Dashboard</h1>
                        <small class="text-muted">{{ now()->format('l, F j, Y - g:i A') }}</small>
                    </div>
                </div>

                <!-- Dashboard Statistics Cards -->
                <div class="row">
                    <!-- Total Students -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Students</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalStudents) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Registrations -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Today's Registrations</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todaysRegistrations }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Payments -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Payments</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPayments }}</div>
                                        @if($overduePayments > 0)
                                            <div class="text-xs text-danger mt-1">{{ $overduePayments }} overdue</div>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Revenue -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Today's Revenue</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($todaysRevenue, 2) }}</div>
                                        @php
                                            $revenueChange = $yesterdaysRevenue > 0 ? (($todaysRevenue - $yesterdaysRevenue) / $yesterdaysRevenue) * 100 : 0;
                                        @endphp
                                        @if($revenueChange > 0)
                                            <div class="text-xs text-success mt-1">+{{ number_format($revenueChange, 1) }}% from yesterday</div>
                                        @elseif($revenueChange < 0)
                                            <div class="text-xs text-danger mt-1">{{ number_format($revenueChange, 1) }}% from yesterday</div>
                                        @else
                                            <div class="text-xs text-muted mt-1">Same as yesterday</div>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <!-- Recent Payments -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Payments</h6>
                            </div>
                            <div class="card-body">
                                @forelse($recentPayments as $payment)
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <div>
                                            <div class="font-weight-bold">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</div>
                                            <small class="text-muted">{{ $payment->payment_date->format('M j, Y') }}</small>
                                        </div>
                                        <span class="badge bg-success">${{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted">No recent payments found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                            </div>
                            <div class="card-body">
                                @forelse($recentActivities as $activity)
                                    <div class="d-flex align-items-center py-2 border-bottom">
                                        <div class="me-3">
                                            <i class="fas fa-{{ 
                                                str_contains(strtolower($activity->action), 'student') ? 'user-plus text-success' : 
                                                (str_contains(strtolower($activity->action), 'payment') ? 'credit-card text-primary' : 
                                                'activity text-secondary')
                                            }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="font-weight-bold">{{ $activity->action }}</div>
                                            @if($activity->description)
                                                <small class="text-muted">{{ Str::limit($activity->description, 50) }}</small>
                                            @endif
                                            <div class="text-xs text-muted">{{ $activity->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No recent activities found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('reception.students.create') }}" class="btn btn-primary btn-block">
                                            <i class="fas fa-user-plus"></i> Add Student
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('reception.payments.create') }}" class="btn btn-success btn-block">
                                            <i class="fas fa-credit-card"></i> Record Payment
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('reception.students.index') }}" class="btn btn-info btn-block">
                                            <i class="fas fa-list"></i> View Students
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('reception.reports.index') }}" class="btn btn-warning btn-block">
                                            <i class="fas fa-chart-bar"></i> Generate Report
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
