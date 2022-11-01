@php
    use App\Models\Recipe;

@endphp

    <!DOCTYPE html>
<html lang="es">
<head>
    <title>TQS RM - Platos</title>
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
                <li class="nav-item"><a href="{{route('inicio')}}" class="nav-link">Inicio</a></li>
                <li class="nav-item active"><a href="{{route('menu')}}" class="nav-link">Platos</a></li>
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
                            {{ Cart::getTotalQuantity()}}

                            <span class="text-xs ml-1">
        </span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-wrap hero-wrap-2"
         style="background-image: url('{{asset('assets/images/bg_3.jpg')}}'); height: 200px;"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center" style="height: 200px;">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{route('inicio')}}">Inicio <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Platos </span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section" style="padding:3em;">
    <div class="container">
        <div class="ftco-search">
            <div class="row">
                <div class="col-md-12 nav-link-wrap">
                    <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        <a class="nav-link ftco-animate active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1"
                           role="tab" aria-controls="v-pills-1" aria-selected="true">Entrantes</a>
                        <a class="nav-link ftco-animate" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2"
                           role="tab" aria-controls="v-pills-2" aria-selected="false">Primer plato</a>
                        <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3"
                           role="tab" aria-controls="v-pills-3" aria-selected="false">Segundo Plato</a>
                        <a class="nav-link ftco-animate" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4"
                           role="tab" aria-controls="v-pills-4" aria-selected="false">Postres</a>
                        <a class="nav-link ftco-animate" id="v-pills-5-tab" data-toggle="pill" href="#v-pills-5"
                           role="tab" aria-controls="v-pills-5" aria-selected="false">Complementos</a>
                        <a class="nav-link ftco-animate" id="v-pills-6-tab" data-toggle="pill" href="#v-pills-6"
                           role="tab" aria-controls="v-pills-6" aria-selected="false">Bebidas</a>

                    </div>
                </div>

                <div class="col-md-12 tab-wrap">
                    {{--
                        const TYPE_STARTERS = 0;
                        const TYPE_FIRST_COURSE = 1;
                        const TYPE_MAIN_COURSE = 2;
                        const TYPE_DESERT = 3;
                        const TYPE_COMPLEMENTS = 4;
                        const TYPE_DRINKS = 5; --}}

                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel"
                             aria-labelledby="day-1-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                {{$recipes = Recipe::where('type', 0, 'and')->where('available', 1)->orderBy('id','desc')->simplePaginate(8) }}
                                @if($recipes != null)
                                    @foreach($recipes as $recipe)
                                        @if($recipe->hasStock())

                                            <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                                <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                                    <div class="menu-img img"
                                                         style="background-image: url({{asset('assets/images/logo.jpg')}});"></div>
                                                    <div class="text d-flex align-items-center">
                                                        <div>
                                                            <div class="d-flex">
                                                                <div class="one-half">
                                                                    <h3>{{$recipe->name}}</h3>
                                                                </div>
                                                                <div class="one-forth">
                                                                    <span class="price">{{$recipe->price}} €</span>
                                                                </div>
                                                            </div>
                                                            <p>
                                                                @if(isset($recipe->food))
                                                                    @foreach($recipe->food as $ingredient)
                                                                        <span>{{$ingredient->name}},</span>
                                                                    @endforeach
                                                                @endif
                                                            </p>
                                                            <form action="{{ route('añadirCarrito') }}" method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{ $recipe->id }}"
                                                                       name="id">
                                                                <input type="hidden" value="{{ $recipe->name }}"
                                                                       name="name">
                                                                <input type="hidden" value="{{ $recipe->price }}"
                                                                       name="price">
                                                                <input type="hidden" value="{{ $recipe->type }}"
                                                                       name="type">
                                                                <input type="hidden" value="1" name="quantity">
                                                                <button
                                                                    class="px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                    Añadir al carrito
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <h3>No hay productos en esta categoria</h3>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                {{$recipes = Recipe::where('type', 1, 'and')->where('available', 1)->orderBy('id','desc')->simplePaginate(8) }}
                                @if($recipes != null)
                                    @foreach($recipes as $recipe)
                                        @if($recipe->hasStock())
                                            <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                                <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                                    <div class="menu-img img"
                                                         style="background-image: url({{asset('assets/images/logo.jpg')}});"></div>
                                                    <div class="text d-flex align-items-center">
                                                        <div>
                                                            <div class="d-flex">
                                                                <div class="one-half">
                                                                    <h3>{{$recipe->name}}</h3>
                                                                </div>
                                                                <div class="one-forth">
                                                                    <span class="price">{{$recipe->price}} €</span>
                                                                </div>
                                                            </div>
                                                            <p>
                                                                @if(isset($recipe->food))
                                                                    @foreach($recipe->food as $ingredient)
                                                                        <span>{{$ingredient->name}},</span>
                                                                    @endforeach
                                                                @endif
                                                            </p>
                                                            <form action="{{ route('añadirCarrito') }}" method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{ $recipe->id }}"
                                                                       name="id">
                                                                <input type="hidden" value="{{ $recipe->name }}"
                                                                       name="name">
                                                                <input type="hidden" value="{{ $recipe->price }}"
                                                                       name="price">
                                                                <input type="hidden" value="{{ $recipe->type }}"
                                                                       name="type">
                                                                <input type="hidden" value="1" name="quantity">
                                                                <button
                                                                    class="px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                    Añadir al carrito
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <h3>No hay productos en esta categoria</h3>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                {{$recipes = Recipe::where('type', 2, 'and')->where('available', 1)->orderBy('id','desc')->simplePaginate(8) }}
                                @if($recipes != null)
                                    @foreach($recipes as $recipe)
                                        @if($recipe->hasStock())
                                            <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                                <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                                    <div class="menu-img img"
                                                         style="background-image: url({{asset('assets/images/logo.jpg')}});"></div>
                                                    <div class="text d-flex align-items-center">
                                                        <div>
                                                            <div class="d-flex">
                                                                <div class="one-half">
                                                                    <h3>{{$recipe->name}}</h3>
                                                                </div>
                                                                <div class="one-forth">
                                                                    <span class="price">{{$recipe->price}} €</span>
                                                                </div>
                                                            </div>
                                                            <p>
                                                                @if(isset($recipe->food))
                                                                    @foreach($recipe->food as $ingredient)
                                                                        <span>{{$ingredient->name}},</span>
                                                                    @endforeach
                                                                @endif
                                                            </p>
                                                            <form action="{{ route('añadirCarrito') }}" method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{ $recipe->id }}"
                                                                       name="id">
                                                                <input type="hidden" value="{{ $recipe->name }}"
                                                                       name="name">
                                                                <input type="hidden" value="{{ $recipe->price }}"
                                                                       name="price">
                                                                <input type="hidden" value="{{ $recipe->type }}"
                                                                       name="type">
                                                                <input type="hidden" value="1" name="quantity">
                                                                <button
                                                                    class="px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                    Añadir al carrito
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <h3>No hay productos en esta categoria</h3>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-day-4-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                {{$recipes = Recipe::where('type', 3, 'and')->where('available', 1)->orderBy('id','desc')->simplePaginate(8) }}
                                @if($recipes != null)
                                    @foreach($recipes as $recipe)
                                        @if($recipe->hasStock())
                                            <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                                <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                                    <div class="menu-img img"
                                                         style="background-image: url({{asset('assets/images/logo.jpg')}});"></div>
                                                    <div class="text d-flex align-items-center">
                                                        <div>
                                                            <div class="d-flex">
                                                                <div class="one-half">
                                                                    <h3>{{$recipe->name}}</h3>
                                                                </div>
                                                                <div class="one-forth">
                                                                    <span class="price">{{$recipe->price}} €</span>
                                                                </div>
                                                            </div>
                                                            <p>
                                                                @if(isset($recipe->food))
                                                                    @foreach($recipe->food as $ingredient)
                                                                        <span>{{$ingredient->name}},</span>
                                                                    @endforeach
                                                                @endif
                                                            </p>
                                                            <form action="{{ route('añadirCarrito') }}" method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{ $recipe->id }}"
                                                                       name="id">
                                                                <input type="hidden" value="{{ $recipe->name }}"
                                                                       name="name">
                                                                <input type="hidden" value="{{ $recipe->price }}"
                                                                       name="price">
                                                                <input type="hidden" value="{{ $recipe->type }}"
                                                                       name="type">
                                                                <input type="hidden" value="1" name="quantity">
                                                                <button
                                                                    class="px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                    Añadir al carrito
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                            @endforeach
                                        @else
                                            <h3>No hay productos en esta categoria</h3>
                                        @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-day-5-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                {{$recipes = Recipe::where('type', 4, 'and')->where('available', 1)->orderBy('id','desc')->simplePaginate(8) }}
                                @if($recipes != null)
                                    @foreach($recipes as $recipe)
                                        @if($recipe->hasStock())
                                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                            <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                                <div class="menu-img img"
                                                     style="background-image: url({{asset('assets/images/logo.jpg')}});"></div>
                                                <div class="text d-flex align-items-center">
                                                    <div>
                                                        <div class="d-flex">
                                                            <div class="one-half">
                                                                <h3>{{$recipe->name}}</h3>
                                                            </div>
                                                            <div class="one-forth">
                                                                <span class="price">{{$recipe->price}} €</span>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            @if(isset($recipe->food))
                                                                @foreach($recipe->food as $ingredient)
                                                                    <span>{{$ingredient->name}},</span>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                        <form action="{{ route('añadirCarrito') }}" method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" value="{{ $recipe->id }}" name="id">
                                                            <input type="hidden" value="{{ $recipe->name }}"
                                                                   name="name">
                                                            <input type="hidden" value="{{ $recipe->price }}"
                                                                   name="price">
                                                            <input type="hidden" value="{{ $recipe->type }}"
                                                                   name="type">
                                                            <input type="hidden" value="1" name="quantity">
                                                            <button
                                                                class="px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                Añadir al carrito
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <h3>No hay productos en esta categoria</h3>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-day-6-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                {{$recipes = Recipe::where('type', 5, 'and')->where('available', 1)->orderBy('id','desc')->simplePaginate(8) }}
                                @if($recipes != null)
                                    @foreach($recipes as $recipe)
                                        @if($recipe->hasStock())
                                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                            <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                                <div class="menu-img img"
                                                     style="background-image: url({{asset('assets/images/logo.jpg')}});"></div>
                                                <div class="text d-flex align-items-center">
                                                    <div>
                                                        <div class="d-flex">
                                                            <div class="one-half">
                                                                <h3>{{$recipe->name}}</h3>
                                                            </div>
                                                            <div class="one-forth">
                                                                <span class="price">{{$recipe->price}} €</span>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            @if(isset($recipe->food))
                                                                @foreach($recipe->food as $ingredient)
                                                                    <span>{{$ingredient->name}},</span>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                        <form action="{{ route('añadirCarrito') }}" method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" value="{{ $recipe->id }}" name="id">
                                                            <input type="hidden" value="{{ $recipe->name }}"
                                                                   name="name">
                                                            <input type="hidden" value="{{ $recipe->price }}"
                                                                   name="price">
                                                            <input type="hidden" value="{{ $recipe->type }}"
                                                                   name="type">
                                                            <input type="hidden" value="1" name="quantity">
                                                            <button
                                                                class="px-4 py-2 bg-blue-800 rounded btn btn-primary">
                                                                Añadir al carrito
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <h3>No hay productos en esta categoria</h3>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

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
