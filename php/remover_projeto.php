<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'db_connect.php';


if ($conn->connect_error) {
    die(json_encode(["mensagem" => "Falha na conexão com o banco de dados."]));
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM projetos WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()) {
    echo json_encode(["mensagem" => "Projeto excluído com sucesso!"]);
} else {
    echo json_encode(["mensagem" => "Erro ao excluir projeto."]);
}

$stmt->close();
$conn->close();
?>