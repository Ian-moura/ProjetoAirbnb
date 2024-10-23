@extends("admin_layout.index")

@section("admin_template")
<h2>Users</h2>
<div class="card mb-4">
<!-- Button trigger modal -->
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Alterar user
    </div>
    <div class="card-body">
    <form method = "POST" action="/user/upd">
        @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
                <div class="modal-body">
                        <input type="hidden" name = "id" value = "{{$user->id}}">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Usuario</label>
                            <input type="text" name = "name" class="form-control" id="name" value = "{{$user->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Descrição da User</label>
                            <input type="text" name = "email" class="form-control" id="email" value = "{{$user->email}}">
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