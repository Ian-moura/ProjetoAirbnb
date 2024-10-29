@include('partes.cabecalho')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2>{{ $propriedade->name }}</h2>
                </div>
                <div class="card-body text-center">
                    @if($propriedade->imagens->isNotEmpty())
                        <img class="img-fluid rounded" 
                             src="{{ asset('storage/' . $propriedade->imagens->first()->image_path) }}" 
                             alt="{{ $propriedade->name }}" 
                             style="max-width: 100%; height: auto; object-fit: cover;">
                    @else
                        <img class="img-fluid rounded" 
                             src="{{ asset('img/default-property.jpg') }}" 
                             alt="Imagem padrão" 
                             style="max-width: 100%; height: auto; object-fit: cover;">
                    @endif

                    <div class="mt-4">
                        <h4>Descrição:</h4>
                        <p>{{ $propriedade->description }}</p>

                        <h5>Endereço:</h5>
                        <p>{{ $propriedade->address }}, {{ $propriedade->zip_code }}</p>

                        <h5>Preço por Noite:</h5>
                        <p>R$ {{ number_format($propriedade->price_per_night, 2, ',', '.') }}</p>

                        <h5>Máximo de Hóspedes:</h5>
                        <p>{{ $propriedade->max_guests }}</p>

                        <h5>Número de Quartos:</h5>
                        <p>{{ $propriedade->bedrooms }}</p>

                        <h5>Número de Banheiros:</h5>
                        <p>{{ $propriedade->bathrooms }}</p>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#comprarModal">
                        Comprar
                    </button>

                    <!-- Botões de Nota -->
                    <div class="mt-3">
                        <h5>Avalie de 1 a 5:</h5>
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="btn btn-warning" onclick="setRating({{ $i }})">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>

                    <!-- Modal para Adicionar Nota -->
                    <div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="notaModalLabel">Adicionar Nota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Avaliação: <span id="selectedRating"></span></p>
                                    <form id="ratingForm" action="{{ route('review.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{ $propriedade->id }}">
                                        <input type="hidden" name="rating" id="ratingValue" value="">
                                        <div class="form-group">
                                            <label for="comment">Comentário (opcional):</label>
                                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-primary" onclick="submitRating()">Enviar Nota</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setRating(rating) {
        document.getElementById('selectedRating').innerText = rating;
        document.getElementById('ratingValue').value = rating;
        $('#notaModal').modal('show');
    }

    function submitRating() {
        document.getElementById('ratingForm').submit();
    }
</script>


<!-- Modal de Compra -->
<div class="modal fade" id="comprarModal" tabindex="-1" role="dialog" aria-labelledby="comprarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprarModalLabel">Confirmar Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="payForm" method="POST" action="{{ route('pagamento') }}">
                    @csrf
                    <p>Você está prestes a comprar a propriedade <strong>{{ $propriedade->name }}</strong>.</p>
                    <p>Preço: R$ {{ number_format($propriedade->price_per_night, 2, ',', '.') }}</p>
                    <p>Deseja continuar com a compra?</p>

                    <input type="hidden" name="transaction_amount" value="{{ $propriedade->price_per_night }}">
                    <input type="hidden" name="description" value="{{ $propriedade->name }}">
                    <input type="hidden" name="id" value="{{ $propriedade->id }}">
                    <input type="hidden" name="email" id="email" value="" required>

                    <!-- Adicione o campo para o método de pagamento -->
                    <div class="form-group">
                        <label for="paymentMethodId">Método de Pagamento</label>
                        <select name="payment_method_id" id="paymentMethodId" class="form-control" required>
                            <option value="visa">Pix</option>
                            <!-- Adicione outros métodos de pagamento se necessário -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="emailInput" class="form-control" placeholder="Digite seu e-mail" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="payForm" class="btn btn-primary">Confirmar Compra</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Atualiza o campo hidden do email com o valor do campo de input
    document.getElementById('emailInput').addEventListener('input', function() {
        document.getElementById('email').value = this.value;
    });
</script>


@include('partes.footer')
