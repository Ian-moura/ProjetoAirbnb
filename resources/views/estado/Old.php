@extends("admin_layout.index")
@section("admin_template")
<h2>Categorias</h2>
<div class="card mb-4">
<!-- Button trigger modal -->
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Categorias
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Novo
        </button>
        <br>
        <br>
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($estado as $linha)
                <tr>
                    <td>{{$linha ->id}}</td>
                    <td>{{$linha ->est_nome}}</td>
                    <td>{{$linha ->est_descricao}}</td>
                    <td>
                        <a href="{{route("estado_ex", ["id" => $linha->id])}}" class="btn btn-danger">
                            <li class = "fa fa-trash"></li>
                        </a>
                        |
                        <a href="{{route("estado_upd", ["id" => $linha->id])}}" class="btn btn-primary">
                            <li class = "fa fa-pencil"></li>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method = "POST" action="/estado">
        @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="est_nome" class="form-label">Nome da Categoria</label>
                            <input type="text" name = "est_nome" class="form-control" id="est_nome">
                        </div>
                        <div class="mb-3">
                            <label for="est_descricao" class="form-label">Descrição da Categoria</label>
                            <input type="text" name = "est_descricao" class="form-control" id="est_descricao">
                        </div>  
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
