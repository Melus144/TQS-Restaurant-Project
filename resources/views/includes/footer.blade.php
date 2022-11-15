<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <a class="navbar-brand" href="#" style="font-size: 32px;">TQS Restaurant Project</a> <br>
                <img src="{{asset('assets/images/logo.jpg')}}" style="max-width: 150px" alt="logo">
            </div>
        </div>
    </div>
</footer>

{{--Actualizar estado bd - ejecutar seeders --}}
<a class="nav-link"
   href="{{route('admin.seed_bd')}}">
    <div class="sb-nav-link-icon"><i class="fas fa-church"></i></div>
    Actualizar estado del restaurante
</a>
