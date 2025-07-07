<?php
session_start();

if (isset($_SESSION['PHPUsername'])) {
    header("Location: index.php"); // nuh uh
    exit();
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
        <script src="js/gpt-message.js" defer></script>
    </head>
    <body>
        <aside>
            <nav id="topbar">
                <!-- A barra de navegação do canto superior-->
                <div>
                    <ul>
                        <li><a href="https://www.roblox.com/home" id="robloxLogo">ROBLOX</a></li>
                        <li><a href="index.html">Home</a></li>
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
                            <a href="login.html"id="login">LOGIN</a>
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
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Dados do formulário
                            $inscriptionName = $_POST['inscriptionName'];
                            $inscriptionUser = $_POST['inscriptionUser'];
                            $inscriptionEmail = $_POST['inscriptionEmail'];
                            $inscriptionTelephone = $_POST['inscriptionTelephone'];

                            // Verifica se usuário existe no ROBLOX
                            require_once 'dataphp/roblox-api.php';
                            $userId = obterUserIdPorNome($inscriptionUser);

                            if ($userId) {
                                // Conecta no banco
                                require_once 'dataphp/dbconnection.php';
                                    // Ajuste: insere avatar na tabela também
                                    $stmt = $conn->prepare("INSERT INTO inscricoes(inscriptionName, inscriptionUser, inscriptionEmail, inscriptionTelephone)
                                                            VALUES (?, ?, ?, ?)");
                                    $stmt->bind_param("ssss", $inscriptionName, $inscriptionUser, $inscriptionEmail, $inscriptionTelephone);
                                    $stmt->execute();
                                    $stmt->close();
                                    $conn->close();

                                    // Redireciona
                                    sleep(3);
                                    header("Location: login.php");
                                    exit();
                            } else {
                                // Caso o usuário não exista
                                echo "<p style='color: red;'>O usuário Roblox informado não existe.</p>";
                            }
                        }
                        
                        ?>
                    </form>

                    <div id="frase"></div>
                </div>
            </main>
        </div>
    </body>
</html>



<?php $conn->close()?>