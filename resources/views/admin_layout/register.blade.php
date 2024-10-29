@include('partes.cabecalho')

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registrar</h3>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif


                                    <form method="post" action="/registrar">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" name="name"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">Nome</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="email"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password"
                                                type="password" placeholder="Password" />
                                            <label for="inputPassword">Senha</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password_confirmation"
                                                type="password" placeholder="Password" />
                                            <label for="inputPassword">Confirmar</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="submit" class="btn btn-primary" value="ENVIAR" />
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


@include('partes.footer')
