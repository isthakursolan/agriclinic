<!doctype html>
<html lang="en">

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AgriClinic | Register</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#28a745" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AgriClinic | Register" />
    <meta name="author" content="AgriClinic" />
    <meta
      name="description"
      content="AgriClinic - Smart agriculture management platform. Register to manage crops, fields, and more."
    />
    <meta
      name="keywords"
      content="Agriculture, AgriClinic, Farmers, Crop Management, Smart Farming, Registration"
    />
    <!--end::Primary Meta Tags-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agri Clinic | Login</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="login-page">
    <main class="app-main">
        @yield('content')
    </main>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
</body>

</html>
