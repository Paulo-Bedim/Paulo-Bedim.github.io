<?php
header("Content-Type: text/xml");
header("Access-Control-Allow-Origin: *");

$host = "localhost"; 
$user = "root"; 
$pass = "";     
$db = "portfolio";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão");
}

$sql = "SELECT titulo, descricao, status FROM projetos";
$result = $conn->query($sql);

$xml = new SimpleXMLElement("<projetos/>");

while ($row = $result->fetch_assoc()) {
    $projeto = $xml->addChild("projeto");
    $projeto->addChild("titulo", $row["titulo"]);
    $projeto->addChild("descricao", $row["descricao"]);
    $projeto->addChild("status", $row["status"]);
}

$conn->close();
echo $xml->asXML();
?>
