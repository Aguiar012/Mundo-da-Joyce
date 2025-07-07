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
