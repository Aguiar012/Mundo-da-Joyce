<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = strtoupper(trim($_POST['nome'] ?? ''));

    $conn = new mysqli('localhost', 'root', '', 'compdb');
    if ($conn->connect_error) {
        echo json_encode(['erro' => 'Erro de conexão']);
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM inscriptions WHERE UPPER(inscriptionName) = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();

    echo json_encode([
        'existe' => ($resultado['total'] > 0),
        'nome' => $nome
    ]);
    
    $stmt->close();
    $conn->close();
}
?>