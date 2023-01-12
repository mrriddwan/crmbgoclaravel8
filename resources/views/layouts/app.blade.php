<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/@vuepic/vue-datepicker@latest/dist/main.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">

    <!-- Scripts -->
    <script src="https://unpkg.com/vue@latest"></script>
    <script src="https://unpkg.com/@vuepic/vue-datepicker@latest"></script>
    {{-- <script src="https://unpkg.com/vue-pdf-embed"></script> --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script type="text/javascript">
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            jsPermissions: {!! auth()->check()
                ? auth()->user()->jsPermissions()
                : 0 !!}
        }
    </script>
    <script src="https://unpkg.com/vue-select@latest"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-blue-800 w-full" id="app">
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header> --}}

        <!-- Page Content -->
        @if (Auth::check())
            <meta name="user-id" content="{{ Auth::user()->id }}" />
            <meta name="user_roles" content="{{ Auth::user()->roles }}" />
            <meta name="user_permissions" content="{{ Auth::user()->permissions }}" />
        @endif
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
