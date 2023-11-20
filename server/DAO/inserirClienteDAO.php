<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cliente'], $_POST['status'])) {
        require_once '../../server/classes/Clientes.php';
        $servicosObj = new Clientes();

        $cliente = $_POST['cliente'];
        $status = $_POST['status'];

        $servicosObj->inserirCliente($cliente, $status);
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
}
?>