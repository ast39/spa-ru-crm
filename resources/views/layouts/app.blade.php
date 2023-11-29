@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @php
        include_once public_path() . '/images/site_sprite.svg';
    @endphp

    {{-- CSS grubber --}}
    @stack('css')

    {{-- Scripts --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Fa Icons CSS (CDN) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div id="app" class="newdesign">

        {{-- Навигация --}}
        @include('layouts.components.navbar')

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Footer --}}
    @include('layouts.components.footer')

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        var token = '{{ csrf_token() }}';
    </script>

    <script type="text/javascript" src="{{ asset('/js/dselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js?v=' . time()) }}"></script>

    {{-- JS grubber --}}
    @stack('js')

</body>
</html>
