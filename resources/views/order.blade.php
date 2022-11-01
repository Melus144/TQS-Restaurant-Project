<!DOCTYPE html>
<html lang="es">
<head>
    <title>TQS RM - Pedido</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('assets/images/logo.jpg')}}">

    <link rel="stylesheet" href="{{asset('assets/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>

<div class="py-1 bg-black top">
    <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
            <div class="col-lg-12 d-block">
                <div class="row d-flex">
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span
                                class="icon-phone2"></span></div>
                        <span class="text"></span>
                    </div>
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span
                                class="icon-paper-plane"></span></div>
                        <span class="text">Contacto</span>
                    </div>
                    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right justify-content-end">
                        <p class="mb-0 register-link"><span>Horario</span> <span></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{route('inicio')}}">TQS Restaurant Project</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menú
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item "><a href="{{route('inicio')}}" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="{{route('menu')}}" class="nav-link">Platos</a></li>
                <li class="nav-item cta"><a href="{{route('carrito')}}" class="nav-link">Pedido</a></li>
                <li class="nav-item">
                    <a href="{{ route('carrito') }}">
                        <div
                            class="flex
                                text-black
                                ml-3
                                p-2
                                "
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                 class="bi bi-cart4" viewBox="0 0 16 16">
                                <path
                                    d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                            </svg>
                            {{ Cart::getTotalQuantity() }}
                            <span class="text-xs ml-1">
        </span>

                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-wrap hero-wrap-2" style="background-image: url({{asset('assets/images/bg_5.jpg')}}"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Pedido</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="{{route('inicio')}}">Inicio <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Pedido </span></p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row d-flex no-gutters">
            <div class="order-md-last ftco-animate makereservation p-4 p-md-5 pt-5">
                <div class="px-4 sm:px-8 sm:6 sm:pt-10 mx-auto mt-2">
                    <h1 class="text-xl md:text-3xl uppercase sm:pt-4 font-weight-bold text-center sm:text-left my-4">
                        Productos en el carrito
                    </h1>


                    <main class="my-4">
                        <div class="container px-6 mx-auto my-4">
                            <div class="flex justify-center my-6">
                                <div class="flex flex-col w-full p-8 text-gray-800 pin-r pin-y md:w-4/5 lg:w-4/5">
                                    @if ($message = Session::get('success'))
                                        <div class="p-4 mb-3 bg-green-400 rounded">
                                            <p class="text-green-800">{{ $message }}</p>
                                        </div>
                                    @endif
                                        @if(isset($cartItems) and count($cartItems) > 0)
                                        <div class="flex-1">
                                        <table class="w-full text-sm lg:text-base" cellspacing="0">
                                            <thead>
                                            <tr class="h-12 uppercase">
                                                <th class="hidden md:table-cell"></th>
                                             {{--   <th class="hidden md:table-cell">Orden</th> --}}
                                                <th class="text-left">Nombre</th>
                                                <th class="pl-5 text-left lg:text-right lg:pl-0">
                                                    <span class="lg:hidden" title="Cantidad"></span>
                                                    <span class="hidden lg:inline">Cantidad</span>
                                                </th>
                                                <th class="hidden text-right md:table-cell"> Precio unitario</th>
                                                <th class="hidden text-right md:table-cell"> </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($cartItems as $item)
                                                    <tr>
                                                        <td class="hidden pb-4 md:table-cell">
                                                            <a href="#">
                                                                <img src="{{asset('assets/images/logo.jpg')}}" class=" rounded w-25" alt="Thumbnail">
                                                            </a>
                                                        </td>
                                                        {{--
                                                        <td>
                                                            <a href="#">
                                                                <p class="mb-2 md:ml-4">{{ $item->type }}</p>
                                                            </a>
                                                        </td> --}}
                                                        <td>
                                                            <a href="{{route('menu')}}">
                                                                <p class="mb-2 md:ml-4">{{ $item->name }}</p>
                                                            </a>
                                                        </td>
                                                        <td class="pl-5 justify-center mt-6 md:justify-end md:flex">
                                                            <div class="h-10 w-28">
                                                                <div class="relative flex flex-row w-full h-8">

                                                                    <form action="{{ route('actualizarCarrito') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{ $item->id}}" >
                                                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                                               class="w-100 text-center bg-gray-300" />
                                                                        <button type="submit" class="w-100 my-2 px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                            Actualizar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="hidden text-right md:table-cell">
                                <span class="text-sm font-medium m-2 lg:text-base">
                                    {{ $item->price }} €
                                </span>
                                                        </td>
                                                        <td class="hidden text-right md:table-cell">
                                                            <form action="{{ route('eliminarCarrito') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" value="{{ $item->id }}" name="id">
                                                                <button class="px-4 m-4 w-50 py-2 bg-blue-800 rounded btn btn-primary">
                                                                    X
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div>
                                            <h3 class="my-3">
                                            <strong>Total: {{ Cart::getTotal() }} € ({{ Cart::getTotalQuantity()}} Productos)</strong>
                                            </h3>
                                        </div>
                                        <div>
                                            <form action="{{ route('vaciarCarrito') }}" method="POST">
                                                @csrf
                                                <button class="px-4 py-2 bg-blue-800 rounded btn btn-primary">Vaciar todo el carrito</button>
                                            </form>
                                        </div>
                                        <div class="w-full my-5">

                                        @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <p class="mb-1">Aquí puedes dejar un comentario sobre tu pedido si lo deseas:</p>
                                            <textarea
                                                maxlength="500"
                                                class="w-full border border-gray-200 p-2"
                                                rows="1"
                                                cols="40"
                                                id="message"
                                                name="message"
                                            ></textarea>

                                        </div>
                                            @endif

                                            {{-- Cart --}}
                                        <div class="w-full flex justify-end items-center my-8">
                                            <a href="{{route('menu')}}">
                                                <button class="ml-4 mb-2 px-4 py-2 bg-blue-800 rounded btn btn-primary mr-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" fill="currentColor"
                                                         class="bi bi-chevron-left mr-2" viewBox="0 0 12 16">
                                                        <path fill-rule="evenodd"
                                                              d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                   Seguir comprando
                                                </button>
                                            </a>

                                            @if(isset($cartItems) and count($cartItems) > 0)
                                            <form action="{{ route('pedido-realizado') }}" id="formulario-pedido" class="form-inline ml-4"  method="POST">
                                                @csrf
                                                <p class="my-2 mb-1 mr-2" style="display: inherit">Número de reserva:</p>
                                                <input
                                                    type="number"
                                                    id="booking_id"
                                                    name="booking_id"
                                                    required="required"
                                                    class="mr-2"
                                                >
                                                <button class="my-2 px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                    Hacer pedido
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" fill="currentColor"
                                                         class="bi bi-chevron-right" viewBox="0 0 12 16">
                                                        <path fill-rule="evenodd"
                                                              d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>

                </div>

        </div>
    </div>



</section>

@include('includes.footer')

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.easing.1.3.js')}}"></script>
<script src="{{asset('assets/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/aos.js')}}"></script>
<script src="{{asset('assets/js/jquery.animateNumber.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/jquery.timepicker.min.js')}}"></script>
<script src="{{asset('assets/js/scrollax.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>
