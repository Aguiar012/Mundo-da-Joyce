<?php
function obterUserIdPorNome($nomeUsuario) {
    $url = "https://users.roblox.com/v1/usernames/users";

    $postData = json_encode([
        "usernames" => [$nomeUsuario],
        "excludeBannedUsers" => false
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_POST, true);

    $resposta = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($resposta, true);
    if (isset($dados['data'][0]['id'])) {
        return $dados['data'][0]['id']; // retorna o ID do usuário
    }
    return false;
}

function obterAvatarRoblox(int $userId, int $size = 150): ?string {
    $url = "https://thumbnails.roblox.com/v1/users/avatar-headshot"
        . "?userIds=" . $userId
        . "&size={$size}x{$size}&format=Png&isCircular=false";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resposta = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($resposta, true);
    return $dados['data'][0]['imageUrl'];
    }
?>