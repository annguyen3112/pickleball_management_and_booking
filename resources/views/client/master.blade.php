<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name') }} - {{ $title }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    {{-- <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}
    <link rel="icon" type="image/png" href="{{ asset('storage/images/pickle_court.png') }}">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('client/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('client/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('client/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('client/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('client/css/app.css') }}" rel="stylesheet">

</head>

<body>
    @yield('content')
    <!-- Vendor JS Files -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('client/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('client/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('client/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('client/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('client/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    {{-- <script src="{{ asset('client/vendor/php-email-form/validate.js') }}"></script> --}}

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('client/js/main.js') }}"></script>
    <script src="{{ asset('client/js/app.js') }}"></script>
    <script src="{{ asset('js/pusher.js') }}"></script>
</body>

</html>
