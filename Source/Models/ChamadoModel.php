<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class ChamadoModel extends Model

{
    private $db;

    protected static $entity = 'chamados'; // Nome da tabela
    protected static $primaryKey = 'id'; // Chave primária

    public function __construct()
    {
        $this->db = Connect::getConn(); // Obtém a conexão com o banco
    }
    /**
     * Método para inserir um novo chamado no banco de dados
     */
    public function inserirChamado(array $data): ?int
    {
        $this->data = (object) $data;

        // Verifica se o usuário está logado na sessão
        if (isset($_SESSION['usuario']) && method_exists($_SESSION['usuario'], 'getId')) {
            $this->data->usuario_id = $_SESSION['usuario']->getId();
        } else {
            $this->message = "Usuário não está logado ou método getId() não existe.";
            error_log("Erro: " . $this->message); // Log para depuração
            return null;
        }

        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            error_log("Erro: Campos obrigatórios não preenchidos.");
            return null;
        }

        // Prepara a query de inserção para o chamado
        $query = "INSERT INTO " . self::$entity . " (titulo, descricao, cep, endereco, usuario_id, orgao_id) 
              VALUES (:titulo, :descricao, :cep, :endereco, :usuario_id, :orgao_id)";

        // Parametriza os valores para a query
        $params = [
            'titulo' => $this->data->titulo,
            'descricao' => $this->data->descricao,
            'cep' => $this->data->cep,
            'endereco' => $this->data->endereco,
            'usuario_id' => $this->data->usuario_id,
            'orgao_id' => $this->data->orgao_id,
        ];

        // Executa a query de inserção no banco e captura o ID retornado
        $lastInsertId = $this->create($query, $params);

        if ($lastInsertId !== null) {
            // Log para depuração
            error_log("ID do chamado inserido: " . $lastInsertId);

            // Agora, insere o histórico de status com o status inicial 'pendente'
            $statusQuery = "INSERT INTO historico_status (chamado_id, status, data_alteracao, observacao)
                        VALUES (:chamado_id, 'pendente', CURRENT_TIMESTAMP, 'Status inicial do chamado')";

            $statusParams = [
                'chamado_id' => $lastInsertId, // Usando o ID do chamado inserido
            ];

            // Executa a inserção do histórico de status
            $this->create($statusQuery, $statusParams);

            return $lastInsertId; // Retorna o ID do último chamado inserido
        } else {
            error_log("Erro: " . $this->message); // Exibe a mensagem de erro detalhada
            return null;
        }
    }







    /**
     * Método para buscar um chamado por ID
     */
    public function findById(int $id)
    {
        $queryChamado = "SELECT c.*, o.nome AS nome_orgao, u.nome AS nome_usuario 
                         FROM chamados c
                         JOIN orgaos o ON c.orgao_id = o.id
                         JOIN usuarios u ON c.usuario_id = u.id
                         WHERE c.id = :id";

        $queryHistorico = "SELECT hs.status, hs.data_alteracao, hs.observacao
                           FROM historico_status hs
                           WHERE hs.chamado_id = :id
                           ORDER BY hs.data_alteracao ASC";

        try {
            // Prepara a consulta principal para o chamado
            $stmtChamado = $this->db->prepare($queryChamado);
            $stmtChamado->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmtChamado->execute();

            // Obtém os dados do chamado
            $chamado = $stmtChamado->fetch(\PDO::FETCH_OBJ);

            if (!$chamado) {
                return null; // Retorna null se o chamado não for encontrado
            }

            // Prepara a consulta para o histórico de status
            $stmtHistorico = $this->db->prepare($queryHistorico);
            $stmtHistorico->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmtHistorico->execute();

            // Obtém o histórico de status como um array de objetos
            $historicoStatus = $stmtHistorico->fetchAll(\PDO::FETCH_OBJ);

            // Adiciona o histórico de status ao objeto do chamado
            $chamado->historicoStatus = $historicoStatus;

            return $chamado; // Retorna o chamado com o histórico de status
        } catch (\PDOException $e) {
            // Captura a exceção e exibe uma mensagem de erro
            error_log("Erro ao buscar chamado e histórico de status: " . $e->getMessage());
            return null; // Retorna null em caso de erro
        }
    }
    /**
     * Lista todos os chamados abertos de um usuário.
     *
     * @param int $usuarioId
     * @return array
     */
    public function listarPorUsuario(int $usuarioId): array
    {
        $query = "SELECT c.id, c.titulo, c.descricao, c.status, o.nome AS nome_orgao, u.nome AS nome_usuario
                  FROM chamados c
                  JOIN orgaos o ON c.orgao_id = o.id
                  JOIN usuarios u ON c.usuario_id = u.id
                  WHERE c.usuario_id = :usuario_id AND c.status = 'pendente'"; // Apenas chamados pendentes

        try {
            // Prepara a consulta
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':usuario_id', $usuarioId, \PDO::PARAM_INT);
            $stmt->execute();

            // Retorna os resultados como um array de objetos
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            // Captura o erro e loga
            error_log("Erro ao listar chamados: " . $e->getMessage());
            return [];
        }
    }







    // Outros métodos...

    /**
     * Método para verificar campos obrigatórios
     */
    private function required(): bool
    {
        // Verifique seus campos obrigatórios aqui
        if (empty($this->data->titulo) || empty($this->data->descricao) || empty($this->data->usuario_id) || empty($this->data->orgao_id)) {
            $this->message = "Campos obrigatórios faltando!";
            return false;
        }
        return true;
    }
}
