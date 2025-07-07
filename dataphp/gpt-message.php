<?php
header('Content-Type: application/json');

$apiKey = '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';

$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "user", "content" => "Dê uma mensagem divertida parecendo um maluco FALANDO DISSE PARABENS POR SE INSCREVER NO TORNEI DE ROBUX DO NOSSO GRUPO. SEJA FREAK"]
    ],
    "temperature" => 0.9
];

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Se der erro, retorna erro
if ($httpCode !== 200 || !$response) {
    echo json_encode(["erro" => "Erro ao conectar à OpenAI."]);
    exit;
}

// Pega o texto da resposta
$resposta = json_decode($response, true);
$mensagem = $resposta['choices'][0]['message']['content'] ?? '';

echo json_encode(["mensagem" => $mensagem]);