@extends("admin_layout.index")
@section("admin_template")
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Estados</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach($estadosComCidades as $itens)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid" src="img/cat-1.jpg" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h3>{{$itens['estado']->est_nome}}</h3>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection
@section("estados_navbar")
    @foreach($estadosComCidades as $itens)
    <div class="nav-item dropdown dropright">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $itens['estado']->est_nome}}<i class="fa fa-angle-right float-right mt-1"></i></a>
        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
            @foreach($itens['cidades'] as $cidade)
            <a href="" class="dropdown-item">{{ $cidade->cidade_nome }}</a>
            @endforeach
        </div>
    </div>
    @endforeach
@endsection
