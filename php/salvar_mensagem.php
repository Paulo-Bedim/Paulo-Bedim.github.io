<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'db_connect.php';

// Pega os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$assunto = $_POST['assunto'];
$mensagem = $_POST['mensagem'];

$sql = "INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);

if ($stmt->execute()) {
    echo json_encode(["success" => "Mensagem enviada com sucesso!"]);
} else {
    echo json_encode(["error" => "Erro ao salvar mensagem."]);
}

$stmt->close();
$conn->close();
?>
