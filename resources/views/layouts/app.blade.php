<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · {{ config('app.name') }}</title>
    <style>
        :root {
            --bg: #f4f6f8;
            --card: #fff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --primary: #2563eb;
            --danger: #dc2626;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        nav {
            background: #111827;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
        }

        nav .brand {
            color: #fff;
            font-weight: 700;
            margin-right: 16px;
            padding: 14px 0;
        }

        nav a.link {
            color: #d1d5db;
            padding: 14px 12px;
            font-size: 14px;
        }

        nav a.link:hover,
        nav a.link.active {
            color: #fff;
            background: #1f2937;
            text-decoration: none;
        }

        .container {
            max-width: 1100px;
            margin: 24px auto;
            padding: 0 16px;
        }

        .card {
            background: var(--card);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .card.narrow {
            max-width: 640px;
        }

        h1 {
            margin: 0 0 16px;
            font-size: 24px;
        }

        h2 {
            margin: 0 0 12px;
            font-size: 17px;
        }

        h3 {
            margin: 20px 0 8px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
        }

        .top h1,
        .top h2 {
            margin: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .grid .full {
            grid-column: 1 / -1;
        }

        .field {
            margin-bottom: 14px;
        }

        .grid .field {
            margin-bottom: 0;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
            font-family: inherit;
        }

        input:disabled {
            background: #f3f4f6;
        }

        input[type=checkbox] {
            width: auto;
        }

        .hint {
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        .error {
            color: var(--danger);
            font-size: 13px;
            margin-top: 3px;
        }

        .btn {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            padding: 8px 16px;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-family: inherit;
        }

        .btn:hover {
            opacity: .9;
            text-decoration: none;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 13px;
        }

        .form-actions {
            margin-top: 20px;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 9px 8px;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
            vertical-align: middle;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
        }

        .right {
            text-align: right;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .actions {
            white-space: nowrap;
        }

        .actions form {
            display: inline;
        }

        .filters {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .filters input,
        .filters select {
            width: auto;
            min-width: 150px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-gray {
            background: #e5e7eb;
            color: #374151;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat {
            background: var(--card);
            padding: 16px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
            color: var(--muted);
            font-size: 13px;
        }

        .stat span {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 2px;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .pager {
            margin-top: 14px;
        }

        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 5px 11px;
            border: 1px solid var(--line);
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
        }

        .pagination li.active span {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .pagination li.disabled span {
            color: #9ca3af;
        }

        @media (max-width: 760px) {

            .grid,
            .two-col {
                grid-template-columns: 1fr;
            }

            .card {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <nav>
        <a href="{{ route('dashboard') }}" class="brand">🐾 {{ config('app.name') }}</a>
        <a class="link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Pet Supplies</a>
        <a class="link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
        <a class="link {{ request()->routeIs('brands.*') ? 'active' : '' }}" href="{{ route('brands.index') }}">Brands</a>
        <a class="link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">Suppliers</a>
        <a class="link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
    </nav>

    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-error">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        @yield('content')
    </div>
</body>

</html>