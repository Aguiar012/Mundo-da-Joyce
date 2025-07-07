<?php
session_start();

if (!isset($_SESSION['PHPUsername'])) {
    header("Location: index.php"); // nuh uh
    exit();
}

require_once 'dataphp/roblox-api.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Votação de Jogos</title>
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
                        <li><a href="index.php">Home</a></li>
                        <?php
                            if (isset($_SESSION['PHPUsername'])) {
                                echo '<li><a href="gamevoting.php">Votação</a></li>';
                                echo '<li><a class="disabledLink">Chat</a></li>';
                                echo '<li><a class="disabledLink">Resultados</a></li>';
                            }
                        ?>
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
                            <?php
                            if (isset($_SESSION['PHPUsername'])) {
                                echo htmlspecialchars($_SESSION['PHPUsername']);
                            } else {
                                echo '<a href="login.html"id="login">LOGIN</a>';
                            }
                            ?>
                        </span>
                    </li>
                </ul>
            </nav>
        </aside>
        <div id="content">
            <main id="background4">
                <br>
                <div class="container form" id="gamevoting">
                    <h2>Escolha o próximo jogo!</h2>
                    <form action="@gamevoting.php" method="post">
                        <div id="gamearea">
                            <label>
                                <input type="radio" name="votedGame" value="TSB" required></input>
                                <img src="img/games/strongestBattlegrounds.jpg" alt="The Strongest Battlegrounds">
                            </label>
                            <label>
                                <input type="radio" name="votedGame" value="FL"></input>
                                <img src="img/games/frontlines.jpg" alt="Frontlines">
                            </label>
                            <label>
                                <input type="radio" name="votedGame" value="NDS"></input>
                                <img src="img/games/naturalDisaster.jpg" alt="Natural Disaster Survival">
                            </label>
                            <label>
                                <input type="radio" name="votedGame" value="LB2"></input>
                                <img src="img/games/lumberTycoon.jpg" alt="Lumber Tycoon 2">
                            </label>
                        </div>
                        <br>
                        <input type="submit" id="botaovotar" value="Votar!" style="padding: 8px 48.5%; background-color: #FFFFFF; border: 0px; color: #000000;">
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>

<?php $conn->close();?>