<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'db_connect.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$assunto = $_POST['assunto'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';

// Verifica se todos os campos foram preenchidos
if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
    echo json_encode(["error" => "Todos os campos são obrigatórios."]);
    exit;
}

$sql = "INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => "Mensagem enviada com sucesso!"]);
    } else {
        echo json_encode(["error" => "Erro ao salvar mensagem: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Erro na preparação da query: " . $conn->error]);
}

$conn->close();
?>
