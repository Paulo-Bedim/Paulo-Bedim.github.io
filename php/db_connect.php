<?php
// Arquivo: /includes/db_connect.php

// Configurações do banco de dados
$host = "localhost";     // Servidor MySQL
$user = "root";          // Usuário do banco de dados
$pass = "";              // Senha do banco de dados
$db   = "portfolio";     // Nome do banco de dados

// Tentativa de conexão
try {
    // Cria uma nova conexão usando MySQLi (orientado a objetos)
    $conn = new mysqli($host, $user, $pass, $db);
    
    // Verifica erros de conexão
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão: " . $conn->connect_error);
    }
    
    // Define o charset para utf8mb4 (suporte a caracteres especiais e emojis)
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    // Exibe mensagem de erro amigável e interrompe a execução
    die("Erro crítico no banco de dados. Por favor, tente novamente mais tarde.");
}

/*
Como usar em outros arquivos:
require_once 'includes/db_connect.php';

// Exemplo de consulta
$sql = "SELECT * FROM projetos";
$result = $conn->query($sql);

// Não feche a conexão aqui! Deixe que o PHP gerencie automaticamente
*/
?>