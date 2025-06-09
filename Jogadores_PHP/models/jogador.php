<?php
class Jogador {
    private $conn;
    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    // buscar jogadores (com filtro de busca opcional)
    public function buscarTodos($busca = '') {
        $sql = "SELECT * FROM jogadores";
        $params = [];

        if (!empty($busca)) {
            $sql .= " WHERE nome LIKE ?";
            $params[] = '%' . $busca . '%';
        }

        $sql .= " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // buscar um  jogador pelo seu ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM jogadores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // adicionar jogador
    public function adicionar($dados) {
        $sql = "INSERT INTO jogadores (nome, jogos, gols, assistencias, minutos_jogados, pe_dominante, posicao_principal, equipe_atual) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $params = [
            $dados['nome'],
            $dados['jogos'],
            $dados['gols'],
            $dados['assistencias'],
            $dados['minutos_jogados'],
            $dados['pe_dominante'],
            $dados['posicao_principal'],
            $dados['equipe_atual']
        ];

        return $stmt->execute($params);
    }

    // editar jogador
    public function editar($dados) {
        $sql = "UPDATE jogadores SET nome = ?, jogos = ?, gols = ?, assistencias = ?, minutos_jogados = ?, pe_dominante = ?, posicao_principal = ?, equipe_atual = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $params = [
            $dados['nome'],
            $dados['jogos'],
            $dados['gols'],
            $dados['assistencias'],
            $dados['minutos_jogados'],
            $dados['pe_dominante'],
            $dados['posicao_principal'],
            $dados['equipe_atual'],
            $dados['id']
        ];

        return $stmt->execute($params);
    }

    // excluir um jogador
    public function excluir($id) {
        $sql = "DELETE FROM jogadores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>