<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once(__DIR__ . '/../db/Connection.php');

class Profissionais
{
    private $conexaoPDO;

    public function __construct()
    {
        $this->conexaoPDO = new Connection();
    }

    public function listarProfissionais()
    {
        try {
            $query = "SELECT idprofissional, nomeprofissional FROM profissionais WHERE idOficina = " . $_SESSION['idOficina'];
            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                $this->gerarSelectHTML($resultados);
            } else {
                echo "Nenhum profissional encontrado.";
            }
        } catch (PDOException $e) {
            die("Erro ao listar profissionais: " . $e->getMessage());
        }
    }

    public function listarProfissionaisTable()
    {
        try {
            $query = "SELECT * FROM profissionais WHERE idOficina = " . $_SESSION['idOficina'];
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

    public function editarProfissionais($idProfissional, $profissional, $status, $comissao)
    {
        try {
            $query = "UPDATE profissionais SET 
                      nomeprofissional = :profissional,
                      statusprofissional = :status,
                      comissaoprofissional = :comissao
                      WHERE idprofissional = :idProfissional";

            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':profissional', $profissional);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':comissao', $comissao, PDO::PARAM_INT);
            $stmt->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);

            $stmt->execute();
            echo "Serviço editado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao editar serviço: " . $e->getMessage());
        }
    }

    public function inserirProfissionais($profissional, $status, $comissao)
    {
        try {
            $query = "INSERT INTO profissionais (nomeprofissional, statusprofissional, comissaoprofissional, idOficina) 
                      VALUES (:profissional, :status, :comissao, :idOficina)";

            $idOficina = $_SESSION['idOficina'];

            $stmt = $this->conexaoPDO->conexao->prepare($query);
            $stmt->bindParam(':profissional', $profissional);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':comissao', $comissao, PDO::PARAM_INT);
            $stmt->bindParam(':idOficina', $idOficina, PDO::PARAM_INT);

            $stmt->execute();
            echo "Serviço inserido com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao inserir serviço: " . $e->getMessage());
        }
    }

    private function gerarSelectHTML($dados)
    {
        echo '<select id="profissional" name="profissionais">';
        foreach ($dados as $profissional) {
            echo '<option value="' . $profissional['idprofissional'] . '">' . $profissional['nomeprofissional'] . '</option>';
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
        echo '<th>Profissional</th>';
        echo '<th>Status</th>';
        echo '<th>Comissão</th>';
        echo '<th>Ações</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $linha = 0;

        foreach ($dados as $servico) {
            echo '<tr>';
            echo '<td>' . $servico['idprofissional'] . '</td>';
            echo '<td>' . $servico['nomeprofissional'] . '</td>';
            if ($servico['statusprofissional'] == "A") {
                echo '<td>Ativo</td>';
            } else {
                echo '<td>Inativo</td>';
            }
            echo '<td>' . $servico['comissaoprofissional'] . '</td>';
            echo '<td>';
            echo '<a href="#" class="btn-editar-cliente" data-toggle="modal" data-target="#modalEditarProfissional" data-id-profissional="' . $servico['idprofissional'] . '">Editar</a>';
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