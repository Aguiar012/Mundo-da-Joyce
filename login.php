<?php
session_start();

if (isset($_SESSION['PHPUsername'])) {
    header("Location: index"); // nuh uh
    exit();
}

$errorInnerText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $loginName = $_POST['loginName'];
    $loginUser = $_POST['loginUser'];
    $loginEmail = $_POST['loginEmail'];
                        
    require_once 'dataphp/roblox-api.php';
    require_once 'dataphp/dbconnection.php';

    $stmt = $conn->prepare("select * from inscricoes where nome_completo = ?");
    $stmt->bind_param("s", $loginName);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        if($data['usuario'] === $loginUser) {
            if($data['email'] === $loginEmail) {
                session_start();
                $_SESSION['PHPUsername'] = $loginUser;
                $_SESSION['PHPName'] = $loginName;
                $_SESSION['PHPUserAvatar'] = obterAvatarRoblox(obterUserIdPorNome($loginUser));
                header("Location: index");
                exit();
            }else{
                $errorInnerText = "Email Inválido";
            }
        }else{
            $errorInnerText = "Usuário Inválido";
        }
    }else{
        $errorInnerText = "Nome Inválido";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login</title>
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
            <main id="background3">
                <br>
                <div class="container form" id="login">
                    <h3 style="text-align: center; margin-top: 10px; margin-bottom: 5px;">Login da Competição</h3>
                    <form action="" method="post">
                        <input type="text" placeholder="Nome Completo" 
                            id="loginName" name="loginName" size="36" required>
                        <br>
                        <input type="text" placeholder="Usuário"
                            id="loginUser" name="loginUser" size="36" required>
                        <br>
                        <input type="email" placeholder="Email" 
                            id="loginEmail" name="loginEmail" size="36" required>
                        <input type="submit" value="Log In" 
                        style="margin-top: 0px; padding: 8px 43%; background-color: #272930; border-color: #FFFFFF; color: #FFFFFF;">
                    </form>
                    <p style="text-align: center;"><?= htmlspecialchars($errorInnerText)?></p>
                    <h6 style="text-align: center;">Não tem uma inscrição? <b><a href="inscription">Se inscreva já!</a></b></h6>
                </div>
            </main>
        </div>
    </body>
</html>

<?php $conn->close()?>