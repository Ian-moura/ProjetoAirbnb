@extends("admin_layout.index")

@section("admin_template")
<h2>Estados</h2>
<div class="card mb-4">
<!-- Button trigger modal -->
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Alterar estado
    </div>
    <div class="card-body">
    <form method = "POST" action="/estado/upd">
        @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
                <div class="modal-body">
                        <input type="hidden" name = "id" value = "{{$estado->id}}">
                        
                        <div class="mb-3">
                            <label for="est_nome" class="form-label">Nome da Estado</label>
                            <input type="text" name = "est_nome" class="form-control" id="est_nome" value = "{{$estado->est_nome}}">
                        </div>
                        <div class="mb-3">
                            <label for="est_descricao" class="form-label">Descrição da Estado</label>
                            <input type="text" name = "est_descricao" class="form-control" id="est_descricao" value = "{{$estado->est_descricao}}">
                        </div>  
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection