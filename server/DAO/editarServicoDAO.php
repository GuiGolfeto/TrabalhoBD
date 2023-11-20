<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idServico'], $_POST['cliente'], $_POST['profissional'], $_POST['dataServico'], $_POST['valorTotal'], $_POST['valorMaoObra'], $_POST['status'])) {
        require_once '../../server/classes/Servicos.php';
        $servicosObj = new Servicos();

        $idServico = $_POST['idServico'];
        $idCliente = $_POST['cliente'];
        $idProfissional = $_POST['profissional'];
        $dataServico = $_POST['dataServico'];
        $dataServico = date("Y-m-d", strtotime($dataServico));
        $valorTotal = $_POST['valorTotal'];
        $valorMaoObra = $_POST['valorMaoObra'];
        $idStatus = $_POST['status'];

        $servicosObj->editarServico($idServico, $idCliente, $idProfissional, $dataServico, $valorTotal, $valorMaoObra, $idStatus);
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
}
?>