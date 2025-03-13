<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$host = "localhost"; 
$user = "root"; // Altere conforme necessário
$pass = "";     // Altere conforme necessário
$db = "portfolio";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
}

$sql = "SELECT titulo, descricao, status FROM projetos";
$result = $conn->query($sql);

$projetos = [];
while ($row = $result->fetch_assoc()) {
    $projetos[] = $row;
}

echo json_encode($projetos);
$conn->close();
?>
