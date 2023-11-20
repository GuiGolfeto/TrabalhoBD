<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once(__DIR__ . '/../db/Connection.php');

class Servicos
{
    private $conexaoPDO;

    public function __construct()
    {
        $this->conexaoPDO = new Connection();
    }

    public function listarServicos()
    {
        try {
            $query = "SELECT s.idServicos, c.Cli_Nome, s.DataServico, p.nomeprofissional, s.ValorTotalServico, s.valormaoobraServico, st.DescricaoStatus
            FROM servicos s
            JOIN clientes c ON c.idClientes = s.Clientes_idClientes
            JOIN profissionais p ON p.idprofissional = s.profissionais_idprofissionais
            JOIN statusservico st ON st.idStatusServico = s.Status_idStatusServico
            WHERE s.idOficina = " . $_SESSION['idOficina'];
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                $this->gerarTabelaHTML($resultados);
            } else {
                echo "Nenhum serviço encontrado.";
            }
        } catch (PDOException $e) {
            die("Erro ao listar serviços: " . $e->getMessage());
        }
    }

    public function editarServico($idServico, $idCliente, $idProfissional, $dataServico, $valorTotal, $valorMaoObra, $idStatus)
    {
        try {
            $query = "UPDATE servicos SET 
                      Clientes_idClientes = :idCliente,
                      profissionais_idprofissionais = :idProfissional,
                      DataServico = :dataServico,
                      ValorTotalServico = :valorTotal,
                      valormaoobraServico = :valorMaoObra,
                      Status_idStatusServico = :idStatus
                      WHERE idServicos = :idServico";

            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt->bindParam(':dataServico', $dataServico);
            $stmt->bindParam(':valorTotal', $valorTotal);
            $stmt->bindParam(':valorMaoObra', $valorMaoObra);
            $stmt->bindParam(':idStatus', $idStatus, PDO::PARAM_INT);

            $stmt->execute();
            echo "Serviço editado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao editar serviço: " . $e->getMessage());
        }
    }

    public function inserirServico($idCliente, $idProfissional, $dataServico, $valorTotal, $valorMaoObra, $idStatus)
    {
        try {
            $query = "INSERT INTO servicos (Clientes_idClientes, profissionais_idprofissionais, DataServico, ValorTotalServico, valormaoobraServico, Status_idStatusServico, idOficina) 
                      VALUES (:idCliente, :idProfissional, :dataServico, :valorTotal, :valorMaoObra, :idStatus, :idOficina)";

            $idOficina = $_SESSION['idOficina'];

            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt->bindParam(':dataServico', $dataServico);
            $stmt->bindParam(':valorTotal', $valorTotal);
            $stmt->bindParam(':valorMaoObra', $valorMaoObra);
            $stmt->bindParam(':idStatus', $idStatus, PDO::PARAM_INT);
            $stmt->bindParam(':idOficina', $idOficina, PDO::PARAM_INT);

            $stmt->execute();
            echo "Serviço inserido com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao inserir serviço: " . $e->getMessage());
        }
    }

    private function gerarTabelaHTML($dados)
    {
        echo '<div class="tabela-container">';
        echo '<table class="tabela">';
        echo '<thead class="thead-fixa">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Cliente</th>';
        echo '<th>Data</th>';
        echo '<th>Profissional</th>';
        echo '<th>Valor Total</th>';
        echo '<th>Mão de Obra</th>';
        echo '<th>Status</th>';
        echo '<th>Ações</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $linha = 0;

        foreach ($dados as $servico) {
            echo '<tr>';
            echo '<td>' . $servico['idServicos'] . '</td>';
            echo '<td>' . $servico['Cli_Nome'] . '</td>';
            echo '<td>' . $servico['DataServico'] . '</td>';
            echo '<td>' . $servico['nomeprofissional'] . '</td>';
            echo '<td>' . $servico['ValorTotalServico'] . '</td>';
            echo '<td>' . $servico['valormaoobraServico'] . '</td>';
            echo '<td>' . $servico['DescricaoStatus'] . '</td>';
            echo '<td>';
            echo '<a href="#" class="btn-editar-servico" data-toggle="modal" data-target="#modalServicos" data-id-servico="' . $servico['idServicos'] . '">Editar</a>';
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