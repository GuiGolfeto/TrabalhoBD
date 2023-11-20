
<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once(__DIR__ . '/../db/Connection.php');

class Status
{
    private $conexaoPDO;

    public function __construct()
    {
        $this->conexaoPDO = new Connection();
    }

    public function listarStatus()
    {
        try {
            $query = "SELECT idStatusServico, DescricaoStatus FROM statusservico";
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                $this->gerarSelectHTML($resultados);
            } else {
                echo "Nenhum status encontrado.";
            }
        } catch (PDOException $e) {
            die("Erro ao listar status: " . $e->getMessage());
        }
    }

    private function gerarSelectHTML($dados)
    {
        echo '<select id="status" name="status">';
        foreach ($dados as $status) {
            echo '<option value="' . $status['idStatusServico'] . '">' . $status['DescricaoStatus'] . '</option>';
        }
        echo '</select>';
    }
}

?>