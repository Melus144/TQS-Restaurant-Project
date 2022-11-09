<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TQS Project</title>

    <link rel="icon" type="image/x-icon" href="/images/favicon.svg">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ mix('dist/admin/css/app.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
            crossorigin="anonymous"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.min.js" defer></script>

    <livewire:styles />
    <livewire:scripts />

    @stack('styles')
</head>
<body class="sb-nav-fixed small">

@include('admin.layouts._header')

<div id="layoutSidenav">
    @include('admin.layouts._sidebar')
    <div id="layoutSidenav_content">
        <main>

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="container-fluid bg-light shadow-sm border-bottom mb-4 px-4 sticky-top">
                @yield('content-header')
            </div>
            <div class="container-fluid px-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                        <strong>Oops!</strong> You should check in on some of those fields below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
        @include('admin.layouts._footer')
    </div>
</div>

<script src="{{ mix('dist/admin/js/app.js') }}"></script>
<script src="https://kit.fontawesome.com/070dddb226.js" crossorigin="anonymous"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>
@stack('scripts')

</body>
</html>
