<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'db_connect.php';

// Processar upload de imagem
$imagem = '';
if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $diretorio = "../img/projetos/";
    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid() . "." . $extensao;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $nome_arquivo);
    $imagem = $nome_arquivo;
}

if(empty($_POST['id'])) {
    // Inserir novo projeto
    $stmt = $conn->prepare("INSERT INTO projetos (titulo, descricao, status, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['titulo'], $_POST['descricao'], $_POST['status'], $imagem);
} else {
    // Atualizar projeto existente
    $stmt = $conn->prepare("UPDATE projetos SET titulo=?, descricao=?, status=?, imagem=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['titulo'], $_POST['descricao'], $_POST['status'], $imagem, $_POST['id']);
}

if($stmt->execute()) {
    echo json_encode(["mensagem" => "Projeto salvo com sucesso!"]);
} else {
    echo json_encode(["mensagem" => "Erro ao salvar projeto."]);
}

$stmt->close();
$conn->close();
?>