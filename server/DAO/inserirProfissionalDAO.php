<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['profissional'], $_POST['status'], $_POST['comissao'])) {
        require_once '../../server/classes/Profissionais.php';
        $servicosObj = new Profissionais();

        $profissional = $_POST['profissional'];
        $status = $_POST['status'];
        $comissao = $_POST['comissao'];

        $servicosObj->inserirProfissionais($profissional, $status, $comissao);
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
}
?>