<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once(__DIR__ . '/../db/Connection.php');

class Clientes
{
    private $conexaoPDO;

    public function __construct()
    {
        $this->conexaoPDO = new Connection();
    }

    public function listarClientes()
    {
        try {
            $query = "SELECT idClientes, Cli_Nome FROM clientes WHERE idOficina = " . $_SESSION['idOficina'];
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                $this->gerarSelectHTML($resultados);
            } else {
                echo "Nenhum cliente encontrado.";
            }
        } catch (PDOException $e) {
            die("Erro ao listar clientes: " . $e->getMessage());
        }
    }

    public function listarClientesTable()
    {
        try {
            $query = "SELECT * FROM clientes WHERE idOficina = " . $_SESSION['idOficina'];
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                $this->gerarTabelaHTML($resultados);
            } else {
                echo "Nenhum cliente encontrado.";
            }
        } catch (PDOException $e) {
            die("Erro ao listar clientes: " . $e->getMessage());
        }
    }

    public function editarCliente($idCliente, $nomeCliente, $statusCliente)
    {
        try {
            $query = "UPDATE clientes SET 
                      Cli_Nome = :nomeCliente,
                      Cli_Status = :statusCliente
                      WHERE idClientes = :idCliente";

            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':nomeCliente', $nomeCliente);
            $stmt->bindParam(':statusCliente', $statusCliente);
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);

            $stmt->execute();
            echo "Serviço editado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao editar serviço: " . $e->getMessage());
        }
    }

    public function inserirCliente($nomeCliente, $statusCliente){
        try {
            $query = "INSERT INTO clientes (Cli_Nome, Cli_Status, idOficina)
                    VALUES (:nomeCliente, :statusCliente, :idOficina)";

            $idOficina = $_SESSION['idOficina'];      
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':nomeCliente', $nomeCliente);
            $stmt->bindParam(':statusCliente', $statusCliente);
            $stmt->bindParam(':idOficina', $idOficina);   

            $stmt->execute();
            echo "Serviço inserido com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao editar serviço: " . $e->getMessage());
        }
    }

    private function gerarSelectHTML($dados)
    {
        echo '<select id="cliente" name="clientes">';
        foreach ($dados as $cliente) {
            echo '<option value="' . $cliente['idClientes'] . '">' . $cliente['Cli_Nome'] . '</option>';
        }
        echo '</select>';
    }


    private function gerarTabelaHTML($dados)
    {
        echo '<div class="tabela-container">';
        echo '<table class="tabela">';
        echo '<thead class="thead-fixa">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Cliente</th>';
        echo '<th>Status</th>';
        echo '<th>Ações</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $linha = 0;

        foreach ($dados as $servico) {
            echo '<tr>';
            echo '<td>' . $servico['idClientes'] . '</td>';
            echo '<td>' . $servico['Cli_Nome'] . '</td>';
            if ($servico['Cli_Status'] == "A"){
                echo '<td>Ativo</td>';
            }else{
                echo '<td>Inativo</td>';
            }
            echo '<td>';
            echo '<a href="#" class="btn-editar-cliente" data-toggle="modal" data-target="#modalCliente" data-id-cliente="' . $servico['idClientes'] . '">Editar</a>';
            echo '</td>';
            echo '</tr>';

            $linha++;
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        // Adiciona o estilo CSS para a tabela-container e thead-fixa
        if ($linha >= 10) {
            echo '<style>';
            echo '.tabela-container { max-height: 500px; overflow-y: auto; }';
            echo '.thead-fixa { position: sticky; top: 0; background-color: #f2f2f2; }';
            echo '</style>';
        }
    }
}
?>