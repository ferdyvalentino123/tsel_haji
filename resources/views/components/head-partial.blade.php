<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="{{ asset('admin_asset/img/icons/icon-48x48.png')}}" />

<link rel="canonical" href="https://demo-basic.adminkit.io/" />

<title>{{ config('app.name') }}</title>

<link href="{{ asset('admin_asset/css/app.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    /* SHARED TOP NAVBAR STYLES */
    .top-navbar {
        background: #fff;
        height: 65px;
        min-height: 65px;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        z-index: 10;
    }

    .hamburger-btn {
        background: none;
        border: none;
        color: #333;
        font-size: 1.25rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .hamburger-btn:hover {
        background: #f0f0f0;
        color: #bc0007; /* Telkomsel Red */
    }

    .nav-user {
        color: #333;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 20px;
        transition: background 0.2s;
    }
    .nav-user:hover {
        background: #f0f0f0;
    }

    @media (max-width: 768px) {
        .top-navbar {
            padding: 0 0.75rem;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
