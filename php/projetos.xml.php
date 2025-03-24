<?php
header("Content-Type: text/xml");
header("Access-Control-Allow-Origin: *");

require_once 'db_connect.php';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão");
}

// Consulta atualizada para incluir id e imagem
$sql = "SELECT id, titulo, descricao, status, imagem FROM projetos";
$result = $conn->query($sql);

$xml = new SimpleXMLElement("<projetos/>");

while ($row = $result->fetch_assoc()) {
    $projeto = $xml->addChild("projeto");
    
    // Adiciona todos os campos necessários
    $projeto->addChild("id", $row["id"]);
    $projeto->addChild("titulo", htmlspecialchars($row["titulo"]));
    $projeto->addChild("descricao", htmlspecialchars($row["descricao"]));
    $projeto->addChild("status", htmlspecialchars($row["status"]));
    
    // Adiciona a imagem se existir
    if(!empty($row["imagem"])) {
        $projeto->addChild("imagem", htmlspecialchars($row["imagem"]));
    }
}

$conn->close();
echo $xml->asXML();
?>