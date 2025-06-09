<?php

class Publicacao {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    /*
    Busca todas as publicações para o feed principal.
     */
    public function buscarTodas($id_usuario_logado) {
        $sql = "
            SELECT 
                p.*, 
                u.nome AS nome_usuario,
                (SELECT COUNT(*) FROM curtidas WHERE id_post = p.id) AS total_curtidas,
                (SELECT COUNT(*) FROM curtidas WHERE id_post = p.id AND id_usuario = ?) AS usuario_curtiu
            FROM 
                publicacoes p
            JOIN 
                usuarios u ON p.id_usuario = u.id
            ORDER BY 
                p.data_publicacao DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_usuario_logado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     Busca as publicações de um usuário específico para a página de perfil.
     */
    public function buscarPorUsuario($id_perfil, $id_usuario_logado) {
        $sql = "
            SELECT 
                p.*, 
                u.nome AS nome_usuario,
                (SELECT COUNT(*) FROM curtidas WHERE id_post = p.id) AS total_curtidas,
                (SELECT COUNT(*) FROM curtidas WHERE id_post = p.id AND id_usuario = ?) AS usuario_curtiu
            FROM 
                publicacoes p
            JOIN 
                usuarios u ON p.id_usuario = u.id
            WHERE 
                p.id_usuario = ? 
            ORDER BY 
                p.data_publicacao DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_usuario_logado, $id_perfil]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
    Busca uma única publicação pelo seu ID.
     */
    public function buscarPorId($id_post) {
        $sql = "SELECT * FROM publicacoes WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_post]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    Adiciona uma nova publicação.
     */
    public function adicionar($id_usuario, $mensagem) {
        if (empty(trim($mensagem))) {
            return false;
        }
        $sql = "INSERT INTO publicacoes (id_usuario, mensagem) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_usuario, $mensagem]);
    }

    /*
    Edita a mensagem de uma publicação, verificando a permissão.
     */
    public function editar($id_post, $nova_mensagem, $id_usuario_logado) {
        $post = $this->buscarPorId($id_post);

        if ($post && $post['id_usuario'] == $id_usuario_logado) {
            // Se for o dono, pode editar
            $sql = "UPDATE publicacoes SET mensagem = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$nova_mensagem, $id_post]);
        }
        return false; 
    }

    /*
    Exclui uma publicação, verificando a permissão.
     */
    public function excluir($id_post, $id_usuario_logado) {
        $sqlVerifica = "SELECT id FROM publicacoes WHERE id = ? AND id_usuario = ?";
        $stmtVerifica = $this->conn->prepare($sqlVerifica);
        $stmtVerifica->execute([$id_post, $id_usuario_logado]);

        if ($stmtVerifica->rowCount() > 0) {
    
            $sqlDelete = "DELETE FROM publicacoes WHERE id = ?";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            return $stmtDelete->execute([$id_post]);
        }
        return false;
    }
}
?>