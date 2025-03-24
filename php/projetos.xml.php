<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Restante do código...
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

require_once 'db_connect.php';

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