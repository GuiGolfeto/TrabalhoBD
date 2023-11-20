<?php
session_start();
require_once '../db/Connection.php';

class Login {
    private $conexaoPDO;

    public function __construct() {
        $this->conexaoPDO = new Connection();
    }

    public function realizarLogin($email, $senha) {
        try {
            $query = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->execute();

            $resultado = $stmt->fetch();

            if ($resultado) {
                $_SESSION['nome'] = $resultado['nome'];
                $_SESSION['idUser'] = $resultado['idusuarios'];
                $_SESSION['email'] = $resultado['email'];
                $_SESSION['idOficina'] = $resultado['idOficina'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Erro durante o login: " . $e->getMessage());
        }
    }
}