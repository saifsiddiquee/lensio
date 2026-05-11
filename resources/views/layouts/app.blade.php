<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lensio') - Event Photography CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/lensio.css'])
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 65px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #1e293b;
            border-right: 1px solid rgba(148, 163, 184, 0.08);
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: width 0.3s ease;
        }

        .sidebar-header {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1rem 1rem 1.5rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.08);
            background: inherit;
        }

        .sidebar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            color: #f1f5f9;
            transition: opacity 0.2s ease, width 0.2s ease;
        }

        .sidebar-brand i {
            font-size: 1.6rem;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            flex-shrink: 0;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(148, 163, 184, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.1);
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .sidebar-toggle:hover {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border-color: rgba(99, 102, 241, 0.3);
        }

        .sidebar-toggle i {
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.75rem 0;
        }

        .nav-section {
            padding: 0.75rem 1.5rem 0.4rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #475569;
            margin-top: 0.25rem;
            white-space: nowrap;
            transition: opacity 0.2s ease;
            font-weight: 600;
        }

        .nav-link {
            color: #94a3b8;
            padding: 0.65rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.875rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            white-space: nowrap;
            margin: 1px 0;
        }

        .nav-link:hover {
            background: rgba(148, 163, 184, 0.06);
            color: #e2e8f0;
        }

        .nav-link.active {
            background: rgba(99, 102, 241, 0.12);
            color: #818cf8;
            border-left-color: #6366f1;
        }

        .nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-link-text {
            transition: opacity 0.2s ease;
        }

        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1rem;
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-brand,
        .sidebar.collapsed .nav-section,
        .sidebar.collapsed .nav-link-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        .sidebar.collapsed .sidebar-brand {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-toggle {
            position: absolute;
            right: 1rem;
        }

        .sidebar.collapsed .nav-link {
            padding: 0.75rem;
            justify-content: center;
            border-left: none;
        }

        .sidebar.collapsed .nav-link i {
            font-size: 1.15rem;
        }

        /* ── Topbar ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #1e293b;
            border-bottom: 1px solid rgba(148, 163, 184, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .sidebar.collapsed ~ .topbar {
            left: var(--sidebar-collapsed-width);
        }

        .topbar h4 {
            font-weight: 600;
            color: #f1f5f9;
            font-size: 1.05rem;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: #94a3b8;
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.2s;
        }

        .mobile-menu-toggle:hover {
            color: #f1f5f9;
        }

        /* User dropdown button */
        .user-dropdown .btn {
            border-radius: 50px;
            padding: 0.45rem 1rem;
            font-weight: 500;
            background: rgba(148, 163, 184, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.12);
            color: #94a3b8;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .user-dropdown .btn:hover {
            background: rgba(99, 102, 241, 0.12);
            color: #818cf8;
            border-color: rgba(99, 102, 241, 0.25);
        }

        /* Role badges */
        .role-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.3rem 0.7rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .role-badge.admin {
            background: rgba(244, 63, 94, 0.15);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.25);
        }

        .role-badge.sales {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.25);
        }

        .role-badge.photographer {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .role-badge.editor {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 1.5rem 2rem;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* ── Overlay for Mobile ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        /* ── Alerts ── */
        .alert {
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-success .btn-close {
            filter: invert(1) brightness(0.7);
        }

        .alert-danger {
            background: rgba(244, 63, 94, 0.12);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.2);
        }

        .alert-danger .btn-close {
            filter: invert(1) brightness(0.7);
        }

        /* ── Mobile Responsiveness ── */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar.mobile-open ~ .sidebar-overlay {
                display: block;
            }

            .sidebar .sidebar-toggle {
                display: none;
            }

            .topbar {
                left: 0 !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 1rem;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .sidebar.collapsed ~ .topbar,
            .sidebar.collapsed ~ .main-content {
                left: 0;
                margin-left: 0;
            }
        }

        @media (max-width: 575.98px) {
            .role-badge {
                display: none;
            }

            .user-dropdown .btn {
                padding: 0.45rem 0.75rem;
            }

            .topbar {
                padding: 0 1rem;
            }
        }
    </style>
    <style>
        /* ── Bootstrap component dark overrides ── */

        /* Cards (Bootstrap native) */
        .card {
            background-color: #1e293b;
            border-color: rgba(148, 163, 184, 0.08);
            color: #f1f5f9;
        }

        .card-header {
            background-color: #1e293b;
            border-bottom-color: rgba(148, 163, 184, 0.08);
            color: #f1f5f9;
        }

        .card-footer {
            background-color: #263348;
            border-top-color: rgba(148, 163, 184, 0.08);
        }

        /* Modals */
        .modal-content {
            background: #1e293b;
            border: 1px solid rgba(148, 163, 184, 0.1);
            color: #f1f5f9;
        }

        .modal-header {
            border-bottom-color: rgba(148, 163, 184, 0.08);
        }

        .modal-footer {
            border-top-color: rgba(148, 163, 184, 0.08);
        }

        .modal-title {
            color: #f1f5f9;
        }

        .btn-close {
            filter: invert(1) brightness(0.6);
        }

        /* Tables */
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #f1f5f9;
            --bs-table-border-color: rgba(148, 163, 184, 0.08);
            --bs-table-hover-bg: #263348;
            --bs-table-striped-bg: rgba(148, 163, 184, 0.03);
            color: #f1f5f9;
        }

        /* List groups */
        .list-group-item {
            background-color: #1e293b;
            border-color: rgba(148, 163, 184, 0.08);
            color: #f1f5f9;
        }

        .list-group-item:hover {
            background-color: #263348;
        }

        /* Nav tabs */
        .nav-tabs {
            border-bottom-color: rgba(148, 163, 184, 0.1);
        }

        .nav-tabs .nav-link {
            color: #94a3b8;
            border-color: transparent;
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .nav-tabs .nav-link:hover {
            color: #f1f5f9;
            border-color: transparent;
            background: rgba(148, 163, 184, 0.06);
        }

        .nav-tabs .nav-link.active {
            background: #1e293b;
            border-color: rgba(148, 163, 184, 0.1) rgba(148, 163, 184, 0.1) #1e293b;
            color: #818cf8;
        }

        /* Breadcrumbs */
        .breadcrumb-item a {
            color: #818cf8;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #94a3b8;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: #475569;
        }

        /* Text utilities */
        .text-muted {
            color: #64748b !important;
        }

        .text-secondary {
            color: #94a3b8 !important;
        }

        /* Horizontal rule */
        hr {
            border-color: rgba(148, 163, 184, 0.1);
            opacity: 1;
        }

        /* Select2 / chosen if used */
        select option {
            background: #263348;
            color: #f1f5f9;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar Overlay (for mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <i class="bi bi-camera-fill"></i>
                <span class="sidebar-brand-text">Lensio</span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>
        <div class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span class="nav-link-text">Dashboard</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isSales())
                <div class="nav-section">Sales Pipeline</div>
                <a href="{{ route('leads.index') }}" class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill"></i>
                    <span class="nav-link-text">Leads</span>
                </a>
                <a href="{{ route('clients.index') }}"
                    class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-link-text">Clients</span>
                </a>
                <a href="{{ route('quotations.index') }}"
                    class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span class="nav-link-text">Quotations</span>
                </a>
            @endif

            <div class="nav-section">Operations</div>
            <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event-fill"></i>
                <span class="nav-link-text">Events</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <i class="bi bi-check2-square"></i>
                <span class="nav-link-text">Tasks</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isSales())
                <div class="nav-section">Finance</div>
                <a href="{{ route('contracts.index') }}"
                    class="nav-link {{ request()->routeIs('contracts.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check-fill"></i>
                    <span class="nav-link-text">Contracts</span>
                </a>
                <a href="{{ route('invoices.index') }}"
                    class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    <span class="nav-link-text">Invoices</span>
                </a>
                <a href="{{ route('payments.index') }}"
                    class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card-fill"></i>
                    <span class="nav-link-text">Payments</span>
                </a>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="nav-section">Admin</div>
                <a href="{{ route('packages.index') }}"
                    class="nav-link {{ request()->routeIs('packages.*') ? 'active' : '' }}">
                    <i class="bi bi-box-fill"></i>
                    <span class="nav-link-text">Packages</span>
                </a>
                <a href="{{ route('equipment.index') }}"
                    class="nav-link {{ request()->routeIs('equipment.*') ? 'active' : '' }}">
                    <i class="bi bi-camera-fill"></i>
                    <span class="nav-link-text">Equipment</span>
                </a>
                <a href="{{ route('employees.index') }}"
                    class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-link-text">Employees</span>
                </a>
                <a href="{{ route('salaries.index') }}"
                    class="nav-link {{ request()->routeIs('salaries.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span class="nav-link-text">Salaries</span>
                </a>
                <a href="{{ route('reports.index') }}"
                    class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span class="nav-link-text">Reports</span>
                </a>
            @endif
        </div>
    </nav>

    <!-- Topbar -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="role-badge {{ auth()->user()->role }}">
                {{ auth()->user()->role }}
            </span>
            <div class="dropdown user-dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i>
                    <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle (Desktop)
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');

        // Load saved state
        if (localStorage.getItem('sidebarCollapsed') === 'true' && window.innerWidth > 991) {
            sidebar.classList.add('collapsed');
        }

        // Desktop toggle
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        // Mobile toggle
        mobileMenuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });

        // Close on overlay click
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
        });

        // Close mobile menu on resize to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 991) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>