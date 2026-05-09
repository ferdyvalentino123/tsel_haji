<!DOCTYPE html>
<html lang="en">

<head>
	<x-head-partial></x-head-partial>
    <style>
        :root {
            --primary: #bc0007;
            --primary-dark: #8a0005;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .sidebar, .sidebar-content {
            background: linear-gradient(160deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        }

        .sidebar-link, .sidebar-brand, .sidebar-header {
            color: #fff !important;
            background: transparent !important;
        }

        .sidebar-item.active .sidebar-link {
            background: rgba(0, 0, 0, 0.15) !important;
            border-left: 4px solid white !important;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .main {
            display: flex;
            flex-direction: column;
            min-width: 0;
            background-color: #f5f7fb;
            flex: 1;
        }

        .content {
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
	<div class="wrapper">
        
		<x-Sales.SalesLeftDrawer></x-Sales.SalesLeftDrawer>

		<div class="main">
            <x-top-drawer></x-top-drawer>

			<div class="content">
                {{ $slot }}
            </div>
		</div>
	</div>

	<script src="{{ asset('admin_asset/js/app.js') }}"></script>

</body>

</html>