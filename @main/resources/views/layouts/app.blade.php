<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/img/favicon.png') }}">
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('assets/admin/css/preloader.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/font-awesome-pro.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/metisMenu.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">
  @yield('css')
</head>

<body class="bg-bodyBg">
  @if (isset($header))
      <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 1">
              {{ $header }}
          </div>
      </header>
  @endif
  <main>
      <div class="eduman-dashboard-area">
          @include('layouts.sidebar')
          {{ $slot }}
      </div>
  </main>

  <x-loader />

  <script src="{{ asset('assets/admin/js/vendor/jquery-3.7.0.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/metisMenu.js') }}"></script>
  <script src="{{ asset('assets/admin/js/jquery.nice-select.js') }}"></script>
  <script src="{{ asset('assets/admin/js/main.js') }}"></script>
  @yield('js')
</body>

</html>
