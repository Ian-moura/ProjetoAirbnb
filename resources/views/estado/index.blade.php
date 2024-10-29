@extends("admin_layout.index")

@section("admin_template")

<div class="container-fluid pt-5">

    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Estados</span>
    </h2>

    <div class="row px-xl-5 pb-3">
        @foreach($estadosComCidades as $item)

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <form action="{{ route('propriedades.search') }}" method="GET" class="d-inline">
                <input type="hidden" name="query" value="{{ $item->est_nome }}">
                <button type="submit" class="text-decoration-none border-0 bg-transparent">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="flex-fill pl-3">
                            <h3>{{ $item->est_nome }}</h3> <!-- Corrigido aqui -->
                        </div>
                    </div>
                </button>
            </form>
        </div>


        @endforeach
    </div>

</div>

@endsection



@section("estados_navbar")
@foreach($estadosComCidades as $item)
    <div class="nav-item dropdown dropright">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            {{ $item->est_nome }} <i class="fa fa-angle-right float-right mt-1"></i>
        </a>
        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
            @if($item->cidades->isNotEmpty())
                @foreach($item->cidades as $cidade)
                    <form action="{{ route('propriedades.search') }}" method="GET" class="d-inline">
                        <input type="hidden" name="query" value="{{ $cidade->cidade_nome }}">
                        <button type="submit" class="dropdown-item border-0 bg-transparent text-left">
                            {{ $cidade->cidade_nome }}
                        </button>
                    </form>
                @endforeach
            @else
                <a href="#" class="dropdown-item">Nenhuma cidade disponível</a>
            @endif
        </div>
    </div>
@endforeach

@endsection


@section("propriedades")
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Featured Properties</span>
        </h2>
        <div class="row px-xl-5">
            @foreach($propriedades->take(4) as $propriedade)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{  asset('storage/' . $propriedade->imagens->first()->image_path)  }}" alt="{{ $propriedade->name }}">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="{{ route('propriedades.show', $propriedade->id) }}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">{{ $propriedade->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>${{ number_format($propriedade->preco_por_noite, 2) }}</h5>
                                @if(isset($propriedade->preco_original)) <!-- Verifica se o preço original está definido -->
                                    <h6 class="text-muted ml-2">
                                        <del>${{ number_format($propriedade->preco_original, 2) }}</del>
                                    </h6>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                            @php
                                // Arredondar a média para o número inteiro mais próximo
                                $averageRating = round($propriedade->average_rating);
                            @endphp

                            @for($i = 1; $i <= 5; $i++)
                                <small class="fa fa-star {{ $i <= $averageRating ? 'text-warning' : 'text-muted' }} mr-1"></small>
                            @endfor
                                <small>({{ $propriedade->reviews_count }})</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section("carrossel")
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#header-carousel" data-slide-to="1"></li>
                    <li data-target="#header-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    @foreach($propriedades->take(3) as $index => $propriedade)
                        <div class="carousel-item position-relative @if($index === 0) active @endif" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="{{ asset('storage/' . $propriedade->imagens->first()->image_path) }}" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{ $propriedade->name }}</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{ $propriedade->description }}</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ route('propriedades.show', $propriedade->id) }}">Ver Detalhes</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @foreach($propriedades->slice(3, 2) as $propriedade)
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="{{ asset('storage/' . $propriedade->imagens->first()->image_path) }}" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">{{ $propriedade->name }}</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection