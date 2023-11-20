<?php
class Connection {
    private $host = "localhost"; //Host utilizada
    private $usuario = "root"; //Usuario utilizado no banco de dados
    private $senha = ""; //Caso necessario senha para conectar no banco
    private $banco = "trabalhobd"; //Nome do banco de dados
    private $charset = "utf8mb4"; //Altere conforme necessário
    private $ssl = ""; //Coloque conforma necessario

    public $conexao;

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->banco;charset=$this->charset";
            $opcoes = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conexao = new PDO($dsn, $this->usuario, $this->senha, $opcoes);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}