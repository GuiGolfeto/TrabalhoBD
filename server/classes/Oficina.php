<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão apenas se não estiver ativa
}

require_once(__DIR__ . '/../db/Connection.php');

class Oficina
{
    private $conexaoPDO;

    public function __construct()
    {
        $this->conexaoPDO = new Connection();
    }

    public function listarOficina()
    {
        try {
            if (isset($_SESSION['idOficina'])) {
                $query = "SELECT * FROM oficinas WHERE id = :idOficina";
                $stmt = $this->conexaoPDO->conexao->prepare($query);
                $stmt->bindParam(':idOficina', $_SESSION['idOficina'], PDO::PARAM_INT);
                $stmt->execute();

                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $_SESSION['oficina'] = $resultado['razaosocial'];
                    $_SESSION['cnpj'] = $resultado['cnpj'];
                    $_SESSION['anoOperacao'] = $resultado['anoOperacao'];
                } else {
                    echo "Nenhum status encontrado.";
                }
            } else {
                echo "ID da oficina não está definido na sessão.";
            }
        } catch (PDOException $e) {
            die("Erro ao listar status: " . $e->getMessage());
        }
    }
}
?>