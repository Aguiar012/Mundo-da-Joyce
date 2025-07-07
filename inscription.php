<?php
session_start();

if (isset($_SESSION['PHPUsername'])) {
    header("Location: index"); // nuh uh
    exit();
}

$userError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $inscriptionName = $_POST['inscriptionName'];
    $inscriptionUser = $_POST['inscriptionUser'];
    $inscriptionEmail = $_POST['inscriptionEmail'];
    $inscriptionTelephone = $_POST['inscriptionTelephone'];

    // Verifica se usuário existe no ROBLOX
    require_once 'dataphp/roblox-api.php';
    $userId = obterUserIdPorNome($inscriptionUser);

    $verificaSQL = "SELECT * FROM inscricoes WHERE 
            nome_completo = ? OR 
            usuario = ? OR 
            email = ? OR 
            telefone = ?";

    require_once 'dataphp/dbconnection.php';

    $verifica = $conn->prepare($verificaSQL);
    $verifica->bind_param("ssss", $inscriptionName, $inscriptionUser, $inscriptionEmail, $inscriptionTelephone);
    $verifica->execute();
    $resultado = $verifica->get_result();

    if ($resultado->num_rows > 0) {
        echo "<p style='color: red;'>Nome, e-mail, usuário ou telefone já está cadastrado!</p>";
        $verifica->close();
        $conn->close();
        exit();
    }

    if ($userId) {
        // Conecta no banco
        require_once 'dataphp/dbconnection.php';
        $stmt = $conn->prepare("INSERT INTO inscricoes(nome_completo, usuario, email, telefone)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $inscriptionName, $inscriptionUser, $inscriptionEmail, $inscriptionTelephone);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        // Redireciona
        sleep(3);
        header("Location: login");
        exit();
    } else {
        // Caso o usuário não exista
        $userError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Inscrição</title>
        <meta name="description" content="Competição de Robux do 2º REDES">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta charset="utf-8">

        <link rel="stylesheet" href="css/style.css">
        <script src="js/logo-and-sidebar.js" defer></script>
    </head>
    <body>
        <aside>
            <nav id="topbar">
                <!-- A barra de navegação do canto superior-->
                <div>
                    <ul>
                        <li><a href="https://www.roblox.com/home" id="robloxLogo">ROBLOX</a></li>
                        <li><a href="index">Home</a></li>
                    </ul>
                </div>
            </nav>
            <br>
            <br>
            <div id="leftbarArea"></div>
            <nav id="leftbar">
                <!-- A barra de navegação do canto esquerdo-->
                <ul>
                    <li>
                        <img width="30px" src="img/defaultProfile.png" alt="Profile Photo">
                        <span id="userName">
                            <a href="login"id="login">LOGIN</a>
                        </span>
                    </li>
                </ul>
            </nav>
        </aside>
        <div id="content">
            <main id="background2">
                <br>
                <div class="container form" id="inscription">
                    <h3 style="text-align: center; margin-top: -5px;">SE INSCREVA JÁ!</h3>
                    <form action="" method="post">
                        <label for="inscriptionName">Nome Completo</label>
                        <input type="text" placeholder="Jane Doe" 
                            id="inscriptionName" name="inscriptionName" size="36" required> <!-- vai para php como $_POST['inscriptionName'] -->
                        <br> <br>
                        <label for="inscriptionUser">Usuário Completo</label>
                        <input type="text" placeholder="Janedoe123"
                            id="inscriptionUser" name="inscriptionUser" size="36" required> <!-- vai para php como $_POST['inscriptionUser'] -->
                        <br> <br>
                        <label for="inscriptionEmail">Email</label>
                        <input type="email" placeholder="example@gmail.com" 
                            id="inscriptionEmail" name="inscriptionEmail" size="36" required> <!-- vai para php como $_POST['inscriptionEmail'] -->
                        <br> <br>
                        <label for="inscriptionTelephone">Telefone</label>
                        <input type="tel" pattern="[0-9]{2}-[0-9]{4-5}-[0-9]{4}" placeholder="XX-XXXX(X)-XXXX" 
                            id="inscriptionTelephone" name="inscriptionTelephone" size="36" required> <!-- vai para php como $_POST['inscriptionTelephone'] -->
                        <br> <br>
                        <input type="submit" value="Enviar" style="padding: 8px 43.5%; background-color: #FFFFFF; border: 0px; color: #000000;">
                        <?= ($userError === false) ? '' : '<p style="text-align=center">O usuário inserido não existe! </p>'?>
                    </form>

                    <div id="frase">
                        Aguardando mensagem do GPT...
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

<script>
(async function(){
    const div = document.getElementById("frase");
    div.innerText = "Carregando mensagem do GPT...";
    try {
        const res = await fetch("dataphp/gpt-message.php");
        const data = await res.json();

        if (data.mensagem) {
            console.log("Mensagem recebida:", data.mensagem);
            div.innerText = data.mensagem;
        } else if (data.erro) {
            div.innerText = "Erro: " + data.erro;
        } else {
            div.innerText = "Erro desconhecido.";
        }
    } catch (e) {
        console.error("Erro ao buscar mensagem:", e);
        div.innerText = "Erro ao buscar mensagem do GPT.";
    }
})();
</script>
