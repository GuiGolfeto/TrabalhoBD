<?php
session_start();
if (!isset($_SESSION['nome'])) {
    echo "<script>alert('Faça o login!')</script>";
    echo "<script>window.location.href='../../index.php';</script>";
    exit;
} else {
    require_once '../../server/classes/Oficina.php';

    $listagemServicos = new Oficina();
    $listagemServicos->listarOficina();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../src/css/card.css">

    <style>
        .nav-link {
            color: black;
        }

        .nav {
            margin-left: 30px;
        }

        .tabela th,
        .tabela td {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: left;
        }

        .tabela th {
            background-color: #f2f2f2;
        }

        .tabela {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- start navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-clientes-tab" data-bs-toggle="pill" data-bs-target="#pills-clientes"
                    type="button" role="tab" aria-controls="pills-clientes" aria-selected="false">Clientes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profissionais-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-profissionais" type="button" role="tab" aria-controls="pills-profissionais"
                    aria-selected="false">Profissionais</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-perfil-tab" data-bs-toggle="pill" data-bs-target="#pills-perfil"
                    type="button" role="tab" aria-controls="pills-perfil" aria-selected="false">Perfil</button>
            </li>
        </ul>
    </nav>
    <!-- end navbar -->

    <!-- start tabs -->
    <div class="container mt-4 d-flex justify-content-center">
        <div class="tab-content" id="pills-tabContent">

            <!-- home -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h2>Serviços</h2>
                <a href="#modalNovoServico" class="btn btn-primary" data-toggle="modal"><span>Novo serviço</span></a>
                <?php
                require_once '../../server/classes/Servicos.php';

                $listagemServicos = new Servicos();
                $listagemServicos->listarServicos();
                ?>
            </div>
            <!-- end home -->

            <!-- clientes -->
            <div class="tab-pane fade" id="pills-clientes" role="tabpanel" aria-labelledby="pills-clientes-tab">
                <h1>clientes</h1>
                <a href="#modalNovoCliente" class="btn btn-primary" data-toggle="modal"><span>Novo cliente</span></a>
                <?php
                require_once '../../server/classes/Clientes.php';

                $listagemServicos = new Clientes();
                $listagemServicos->listarClientesTable();
                ?>
            </div>
            <!-- end clientes -->

            <!-- profissionais -->
            <div class="tab-pane fade" id="pills-profissionais" role="tabpanel"
                aria-labelledby="pills-profissionais-tab">
                <h1>Profissionais</h1>
                <a href="#modalNovoProfissional" class="btn btn-primary" data-toggle="modal"><span>Novo
                        profissional</span></a>
                <?php
                require_once '../../server/classes/Profissionais.php';

                $listagemServicos = new Profissionais();
                $listagemServicos->listarProfissionaisTable();
                ?>
            </div>
            <!-- end profissionais -->

            <!-- perfil -->
            <div class="tab-pane fade" id="pills-perfil" role="tabpanel" aria-labelledby="pills-perfil-tab">
                <div class="card-container">
                    <img class="round" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" alt="user" />
                    <h3>
                        <?php echo $_SESSION["nome"] ?>
                    </h3>
                    <h6>
                        <?php echo $_SESSION['oficina'] ?>
                    </h6>
                    <p>CNPJ: <?php echo $_SESSION['cnpj'] ?></p>
                    <p>Ano operação: <?php echo $_SESSION['anoOperacao'] ?></p> 
                    
                    <div class="skills">
                        
                    </div>
                </div>
            </div>
            <!-- end perfil -->
        </div>
    </div>
    <!-- end tabs -->

    <!-- start modal -->

    <!-- Modal Editar Servicos -->
    <div id="modalServicos" tabindex="-1" role="dialog" aria-labelledby="modalServicos" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar serviço</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarServico" class="needs-validation" novalidate>
                        <input type="hidden" name="idServico" id="idServicoInput">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cliente">Cliente:</label>
                                    <?php
                                    require_once '../../server/classes/Clientes.php';
                                    $clientesObj = new Clientes();
                                    $clientesObj->listarClientes();
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profissional">Profissional:</label>
                                    <?php
                                    require_once '../../server/classes/Profissionais.php';
                                    $profissionaisObj = new Profissionais();
                                    $profissionaisObj->listarProfissionais();
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <?php
                                    require_once '../../server/classes/Status.php';
                                    $statusObj = new Status();
                                    $statusObj->listarStatus();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dataServico">Data do Serviço:</label>
                            <input type="date" name="dataServico" id="dataServico" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="valorTotal">Valor Total:</label>
                            <input type="text" name="valorTotal" id="valorTotal" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="valorMaoObra">Valor Mão de Obra:</label>
                            <input type="text" name="valorMaoObra" id="valorMaoObra" class="form-control">
                            <input type="text" name="idOficina" id="idOficina"
                                value="<?php echo $_SESSION["idOficina"] ?>" hidden>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="btnEnviar" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Editar Servicos -->

    <!-- Modal Novo Servico -->
    <div id="modalNovoServico" tabindex="-1" role="dialog" aria-labelledby="modalServicos" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar serviço</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarServico" class="needs-validation" novalidate>
                        <input type="hidden" name="idServico" id="idServicoInput">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cliente">Cliente:</label>
                                    <?php
                                    require_once '../../server/classes/Clientes.php';
                                    $clientesObj = new Clientes();
                                    $clientesObj->listarClientes();
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profissional">Profissional:</label>
                                    <?php
                                    require_once '../../server/classes/Profissionais.php';
                                    $profissionaisObj = new Profissionais();
                                    $profissionaisObj->listarProfissionais();
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <?php
                                    require_once '../../server/classes/Status.php';
                                    $statusObj = new Status();
                                    $statusObj->listarStatus();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dataServico">Data do Serviço:</label>
                            <input type="date" name="dataServico2" id="dataServico2" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="valorTotal">Valor Total:</label>
                            <input type="text" name="valorTotal2" id="valorTotal2" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="valorMaoObra">Valor Mão de Obra:</label>
                            <input type="text" name="valorMaoObra2" id="valorMaoObra2" class="form-control">
                        </div>

                        <!-- Adicione outros campos conforme necessário -->

                        <div class="modal-footer">
                            <button type="button" id="btnNovoServico" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Novo Servico -->

    <!-- Modal Editar Cliente -->
    <div id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalCliente" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar cliente</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarCliente" class="needs-validation" novalidate>
                        <input type="hidden" name="idCliente" id="idCliente">
                        <div class="row">
                            <div class="form-group">
                                <label for="clienteNome">Cliente:</label>
                                <input type="text" name="clienteNome" id="clienteNome" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="statusCliente">Status(A/I):</label>
                                <input type="text" name="statusCliente" id="statusCliente" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnEnviarCliente" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Editar Cliente -->

    <!-- Modal Novo Cliente -->
    <div id="modalNovoCliente" tabindex="-1" role="dialog" aria-labelledby="modalNovoCliente" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Novo cliente</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarCliente" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="form-group">
                                <label for="clienteNomeNovo">Cliente:</label>
                                <input type="text" name="clienteNomeNovo" id="clienteNomeNovo" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="statusClienteNovo">Status(A/I):</label>
                                <input type="text" name="statusClienteNovo" id="statusClienteNovo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnCriarCliente" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Novo Cliente -->

    <!-- Modal Editar Profissional -->
    <div id="modalEditarProfissional" tabindex="-1" role="dialog" aria-labelledby="modalEditarProfissional"
        aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Novo profissional</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarCliente" class="needs-validation" novalidate>
                        <input type="hidden" name="idProfissional" id="idProfissional">
                        <div class="row">
                            <div class="form-group">
                                <label for="nomeProfissional">Profissional:</label>
                                <input type="text" name="nomeProfissional" id="nomeProfissional" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="statusProfissional">Status(A/I):</label>
                                <input type="text" name="statusProfissional" id="statusProfissional"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="comissaoProfissional">Comissão:</label>
                                <input type="text" name="comissaoProfissional" id="comissaoProfissional"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnEnviarProfissional" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Editar Profissional -->

    <!-- Modal Novo Cliente -->
    <div id="modalNovoCliente" tabindex="-1" role="dialog" aria-labelledby="modalNovoCliente" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Novo cliente</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarCliente" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="form-group">
                                <label for="clienteNomeNovo">Cliente:</label>
                                <input type="text" name="clienteNomeNovo" id="clienteNomeNovo" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="statusClienteNovo">Status(A/I):</label>
                                <input type="text" name="statusClienteNovo" id="statusClienteNovo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnCriarCliente" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Novo Cliente -->

    <!-- Modal Editar Profissional -->
    <div id="modalEditarProfissional" tabindex="-1" role="dialog" aria-labelledby="modalEditarProfissional"
        aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar profissional</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarCliente" class="needs-validation" novalidate>
                        <input type="hidden" name="idProfissional" id="idProfissional">
                        <div class="row">
                            <div class="form-group">
                                <label for="nomeProfissional">Profissional:</label>
                                <input type="text" name="nomeProfissional" id="nomeProfissional" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="statusProfissional">Status(A/I):</label>
                                <input type="text" name="statusProfissional" id="statusProfissional"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="comissaoProfissional">Comissão:</label>
                                <input type="text" name="comissaoProfissional" id="comissaoProfissional"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnEnviarProfissional" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Editar Profissional -->

    <!-- Modal Novo Profissional -->
    <div id="modalNovoProfissional" tabindex="-1" role="dialog" aria-labelledby="modalNovoProfissional"
        aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Novo profissional</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Adicione o formulário aqui -->
                    <form id="formEditarCliente" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="form-group">
                                <label for="nomeProfissionalNovo">Profissional:</label>
                                <input type="text" name="nomeProfissionalNovo" id="nomeProfissionalNovo"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="statusProfissionalNovo">Status(A/I):</label>
                                <input type="text" name="statusProfissionalNovo" id="statusProfissionalNovo"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="comissaoProfissionalNovo">Comissão:</label>
                                <input type="text" name="comissaoProfissionalNovo" id="comissaoProfissionalNovo"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnNovoProfissional" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Novo Profissional -->

    <!-- end Modal -->


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#modalServicos').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var idServico = button.data('id-servico');
                $('#idServicoInput').val(idServico);
            });

            $('#btnEnviar').on('click', function () {
                var formData = {
                    idServico: $('#idServicoInput').val(),
                    cliente: $('#cliente').val(),
                    profissional: $('#profissional').val(),
                    dataServico: $('#dataServico').val(),
                    valorTotal: $('#valorTotal').val(),
                    valorMaoObra: $('#valorMaoObra').val(),
                    status: $('#status').val(),
                    idOficina: $('#idOficina').val()
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '../../server/DAO/editarServicoDAO.php',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.reload(true);
                    },
                    error: function (error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            });


            $('#btnNovoServico').on('click', function () {
                var formData = {
                    cliente: $('#cliente').val(),
                    profissional: $('#profissional').val(),
                    dataServico: $('#dataServico2').val(),
                    valorTotal: $('#valorTotal2').val(),
                    valorMaoObra: $('#valorMaoObra2').val(),
                    status: $('#status').val()
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '../../server/DAO/inserirServicoDAO.php',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.reload(true);
                    },
                    error: function (error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            });


            $('#modalCliente').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var idCliente = button.data('id-cliente');
                $('#idCliente').val(idCliente);
            });

            $('#btnEnviarCliente').on('click', function () {
                var formData = {
                    idCliente: $('#idCliente').val(),
                    cliente: $('#clienteNome').val(),
                    status: $('#statusCliente').val()
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '../../server/DAO/editarClienteDAO.php',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.reload(true);
                    },
                    error: function (error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            });

            $('#btnCriarCliente').on('click', function () {
                var formData = {
                    cliente: $('#clienteNomeNovo').val(),
                    status: $('#statusClienteNovo').val()
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '../../server/DAO/inserirClienteDAO.php',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.reload(true);
                    },
                    error: function (error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            });

            $('#modalEditarProfissional').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var idCliente = button.data('id-profissional');
                $('#idProfissional').val(idCliente);
            });

            $('#btnEnviarProfissional').on('click', function () {
                var formData = {
                    idProfissional: $('#idProfissional').val(),
                    profissional: $('#nomeProfissional').val(),
                    status: $('#statusProfissional').val(),
                    comissao: $('#comissaoProfissional').val()
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '../../server/DAO/editarProfissionalDAO.php',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.reload(true);
                    },
                    error: function (error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            });

            $('#btnNovoProfissional').on('click', function () {
                var formData = {
                    profissional: $('#nomeProfissionalNovo').val(),
                    status: $('#statusProfissionalNovo').val(),
                    comissao: $('#comissaoProfissionalNovo').val()
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '../../server/DAO/inserirProfissionalDAO.php',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.reload(true);
                    },
                    error: function (error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            });
        });



    </script>

</body>

</html>