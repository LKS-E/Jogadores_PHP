<?php

class Comentario {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function buscarPorPost($id_post) {
        $sql = "SELECT c.*, u.nome AS nome_comentarista 
                FROM comentarios c 
                JOIN usuarios u ON c.id_usuario = u.id 
                WHERE c.id_post = ? 
                ORDER BY c.data_comentario ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_post]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    Adiciona um novo comentário a um post.
     */
    public function adicionar($id_post, $id_usuario, $comentario_texto) {
        if (empty(trim($comentario_texto))) {
            return false;
        }

        $sql = "INSERT INTO comentarios (id_post, id_usuario, comentario) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_post, $id_usuario, $comentario_texto]);
    }

    /*
     Exclui comentario, dono do comentario ou do post 
     */
    public function excluir($id_comentario, $id_usuario_logado) {
        $sqlBusca = "SELECT id_usuario, id_post FROM comentarios WHERE id = ?";
        $stmtBusca = $this->conn->prepare($sqlBusca);
        $stmtBusca->execute([$id_comentario]);
        $comentario = $stmtBusca->fetch();

        if (!$comentario) {
            return false;
        }

        $sqlBuscaPost = "SELECT id_usuario FROM publicacoes WHERE id = ?";
        $stmtBuscaPost = $this->conn->prepare($sqlBuscaPost);
        $stmtBuscaPost->execute([$comentario['id_post']]);
        $post = $stmtBuscaPost->fetch();

        // Se o usuário logado for o dono do comentário OU o dono do post, ele pode excluir
        if ($post && ($comentario['id_usuario'] == $id_usuario_logado || $post['id_usuario'] == $id_usuario_logado)) {
            $sqlDelete = "DELETE FROM comentarios WHERE id = ?";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            return $stmtDelete->execute([$id_comentario]);
        }

        return false; 
    }
}
?>