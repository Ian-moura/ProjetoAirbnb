@include('partes.cabecalho')

<form action="{{ route('criarPropriedade') }}" method="GET">
    @csrf
    <button type="submit" class="btn btn-primary">Adicionar Propriedade</button>
</form>

<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Suas propriedades</span>
    </h2>
    <div class="row px-xl-5">
        @foreach($propriedades as $propriedade)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        @if($propriedade->imagens->isNotEmpty())
                            <!-- Exibe a primeira imagem da coleção de imagens da propriedade -->
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $propriedade->imagens->first()->image_path) }}" alt="{{ $propriedade->name }}">
                        @else
                            <!-- Exibe uma imagem padrão se não houver imagens associadas -->
                            <img class="img-fluid w-100" src="{{ asset('img/default-property.jpg') }}" alt="Imagem padrão">
                        @endif
                        <div class="product-action">
                            <!-- Botão de Editar -->
                            <a class="btn btn-outline-dark btn-square" href="{{ route('propriedades.edit', $propriedade->id) }}">
                                <i class="fa fa-pencil-alt"></i> <!-- Ícone de lápis para editar -->
                            </a>

                            <!-- Botão de Excluir com formulário -->
                            <a class="btn btn-outline-dark btn-square" href="{{ route('propriedades.delete', $propriedade->id) }}">
                                    <i class="fa fa-trash"></i> <!-- Ícone de lixeira para excluir -->
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{ $propriedade->name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>${{ number_format($propriedade->price_per_night, 2) }}</h5>
                            @if(isset($propriedade->preco_original))
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



    @include('partes.footer')