
@include('partes.cabecalho')

<form action="{{ route('propriedades.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Nome da Propriedade</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="description">Descrição</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="address">Endereço</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="zip_code">Código Postal</label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" required>
    </div>
    <div class="form-group">
        <label for="price_per_night">Preço por Noite</label>
        <input type="number" class="form-control" id="price_per_night" name="price_per_night" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="max_guests">Máximo de Hóspedes</label>
        <input type="number" class="form-control" id="max_guests" name="max_guests" required>
    </div>
    <div class="form-group">
        <label for="bedrooms">Número de Quartos</label>
        <input type="number" class="form-control" id="bedrooms" name="bedrooms">
    </div>
    <div class="form-group">
        <label for="bathrooms">Número de Banheiros</label>
        <input type="number" class="form-control" id="bathrooms" name="bathrooms">
    </div>
    <div class="form-group">
        <label for="amenities">Amenidades (JSON)</label>
        <textarea class="form-control" id="amenities" name="amenities"></textarea>
    </div>
    <div class="form-group">
        <label for="estado_id">Estado</label>
        <select class="form-control" id="estado_id" name="estado_id" required>
          <option value="">Selecione um estado</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id }}">{{ $estado->est_nome }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="cidade_id">Cidade</label>
        <select class="form-control" id="cidade_id" name="cidade_id" required>
        <option value="">Selecione uma cidade</option>
            @foreach($cidades as $cidade)
                <option value="{{ $cidade->id }}">{{ $cidade->cidade_nome }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="images">Imagens da Propriedade</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Criar Propriedade</button>
</form>


@include('partes.footer')