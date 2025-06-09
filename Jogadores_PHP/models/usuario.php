<?php
class Usuario {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function registrar($nome, $cpf, $data_nascimento, $senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, cpf, data_nascimento, senha) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute([$nome, $cpf, $data_nascimento, $senha_hash]);
            return true; 
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function verificarLogin($nome, $senha) {
        $sql = "SELECT * FROM usuarios WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nome]);

        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario; 
        }

        return false; 
    }
    
    public function buscarPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarSenha($id, $nova_senha) {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute([$senha_hash, $id]);
    }
  
    public function buscarPorCpfEDataNascimento($cpf, $data_nascimento) {
        $sql = "SELECT * FROM usuarios WHERE cpf = ? AND data_nascimento = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$cpf, $data_nascimento]);
       
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


?>