<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'fiscal_cidadao');

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coletando os dados do formulário
$titulo = trim($_POST['titulo']);
$descricao = trim($_POST['descricao']);
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$orgao_id = $_POST['orgao_id'];
session_start();
$usuario_id = $_SESSION['usuario_id'] ?? null; // ID do usuário autenticado (capturado da sessão)

// Validando os dados recebidos
if (!$usuario_id) {
    die("Erro: Usuário não autenticado.");
}
if (empty($titulo) || empty($descricao)) {
    die("Erro: Título e descrição são obrigatórios.");
}
if (!is_numeric($latitude) || !is_numeric($longitude)) {
    die("Erro: Localização inválida.");
}

// Inserindo o chamado no banco de dados
$sql = "INSERT INTO chamados (titulo, descricao, localizacao, usuario_id, orgao_id) 
        VALUES (?, ?, POINT(?, ?), ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssddi", $titulo, $descricao, $latitude, $longitude, $usuario_id, $orgao_id);

if ($stmt->execute()) {
    // Redirecionar para a página de detalhes do chamado
    $chamado_id = $stmt->insert_id; // Obter o ID do chamado recém-criado
    header("Location: detalhesChamado.php?id=$chamado_id");
    exit();
} else {
    echo "Erro ao abrir o chamado: " . htmlspecialchars($stmt->error);
}

// Fechando a conexão
$stmt->close();
$conn->close();
