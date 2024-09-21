@php
    use App\Libs\Icons;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('/images/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

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
    <link rel="stylesheet" href="{{ asset('css/app.css?v=180924') }}">
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

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        @auth
            <a href="{{ route('cabinet.index') }}" title="Кабинет">{!! Icons::get(Icons::DEMO) !!}</a>
            @if(Gate::allows('owner') || Gate::allows('admin'))
                <a href="{{ route('dict.user.index') }}" title="Сотрудники">{!! Icons::get(Icons::EMPLOYEES) !!}</a>
            @endif
            <a href="{{ route('dict.program.index') }}" title="Прайс">{!! Icons::get(Icons::PRICE) !!}</a>
        @endauth
        @guest
            @if (Route::has('login'))
                <a href="{{ route('login') }}" title="Вход">{!! Icons::get(Icons::LOGIN) !!}</a>
            @endif
        @else
            @if(Gate::allows('owner'))
                <a href="{{ route('report.index') }}" title="Отчеты">{!! Icons::get(Icons::REPORTS) !!}</a>
            @elseif(Gate::allows('admin'))
                <a href="{{ route('report.show') }}" title="Последний отчет">{!! Icons::get(Icons::REPORTS) !!}</a>
            @endif
            <a href="{{ route('shift.index') }}" title="Смена">{!! Icons::get(Icons::SHIFT) !!}</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {!! Icons::get(Icons::LOGOUT) !!}
            </a>
        @endguest
    </div>

    {{-- Footer --}}
    @include('layouts.components.footer')

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        var token = '{{ csrf_token() }}';
    </script>

    <script type="text/javascript" src="{{ asset('/js/dselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js?v=' . time()) }}"></script>

    @push('js')
        <script>
            $(document).ready(function() {
                // Инкремент значений
                $('.btn-increment').click(function() {
                    var input = $(this).siblings('.percent-input');
                    var currentVal = parseInt(input.val());
                    var maxVal = parseInt(input.data('max'));
                    var step = parseInt(input.data('step'));

                    if (currentVal < maxVal && !input.prop('disabled')) {
                        input.val(currentVal + step);
                    }
                });

                // Декремент значений
                $('.btn-decrement').click(function() {
                    var input = $(this).siblings('.percent-input');
                    var currentVal = parseInt(input.val());
                    var minVal = parseInt(input.data('min'));
                    var step = parseInt(input.data('step'));

                    if (currentVal > minVal && !input.prop('disabled')) {
                        input.val(currentVal - step);
                    }
                });
            })
        </script>
    @endpush
d
    {{-- JS grubber --}}
    @stack('js')
    @stack('js2')

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service Worker был зарегистрирован для области действия: " + reg.scope);
            });
        }
    </script>
</body>
</html>
