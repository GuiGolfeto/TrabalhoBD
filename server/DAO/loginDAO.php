<?php
require_once("../classes/Login.php");

$login = new Login();

$email = $_POST['email'];
$senha = $_POST['senha'];

if ($login->realizarLogin($email, $senha)) {
    header('Location: ../../client/pages/home.php');
} else {
    echo "Credenciais inválidas!";
}