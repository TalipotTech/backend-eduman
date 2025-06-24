<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset("assets/admin/css/font-awesome-pro.css") }}">
	<link rel="stylesheet" href="{{ asset("assets/admin/css/metisMenu.css") }}">
	<link rel="stylesheet" href="{{ asset("assets/admin/css/swiper-bundle.css") }}">
	<link rel="stylesheet" href="{{ asset("assets/admin/css/nice-select.css") }}">
	<link rel="stylesheet" href="{{ asset("assets/admin/css/main.css") }}">
	<title>Eduman - Learning Management System</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
	<!-- Scripts -->
	
</head>

<body class="bg-bodyBg">
	<main>
		{{ $slot }}
	</main>

	<script src="{{ asset('assets/admin/js/vendor/jquery-3.7.0.min.js') }}"></script>
	<script src="{{ asset('assets/admin/js/metisMenu.js') }}"></script>
	<script src="{{ asset('assets/admin/js/jquery.nice-select.js') }}"></script>
	<script src="{{ asset('assets/admin/js/apexcharts.js') }}"></script>
	<script src="{{ asset('assets/admin/js/swiper-bundle.min.js') }}"></script>
	<script src="{{ asset('assets/admin/js/main.js') }}"></script>
	@yield('js')
</body>

</html>
