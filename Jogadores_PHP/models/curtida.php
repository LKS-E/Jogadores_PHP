<?php

class Curtida {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    /*
     Alterna o estado da curtida de um usuário em um post.
     Se já curtiu, descurte. Se não curtiu, curte.
     */
    public function alternarCurtida($id_post, $id_usuario) {

        $sqlVerifica = "SELECT id FROM curtidas WHERE id_post = ? AND id_usuario = ?";
        $stmtVerifica = $this->conn->prepare($sqlVerifica);
        $stmtVerifica->execute([$id_post, $id_usuario]);
        $curtida_existente = $stmtVerifica->fetch();

        if ($curtida_existente) {
            $sqlDelete = "DELETE FROM curtidas WHERE id = ?";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            return $stmtDelete->execute([$curtida_existente['id']]);
        } else {
            $sqlInsert = "INSERT INTO curtidas (id_post, id_usuario) VALUES (?, ?)";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            return $stmtInsert->execute([$id_post, $id_usuario]);
        }
    }
}
?>