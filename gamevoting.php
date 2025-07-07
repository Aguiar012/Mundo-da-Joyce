<?php
session_start();

if (!isset($_SESSION['PHPUsername'])) {
    header("Location: index"); // nuh uh
    exit();
}

require_once 'dataphp/dbconnection.php';
$submitValue = "Votar!";
$votedGame = null;

$voteName = $_SESSION['PHPName'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoVoto = $_POST['votedGame'] ?? '';

    if ($novoVoto !== '') {
        // Verificacao top das galaxia
        $stmt = $conn->prepare("SELECT votedGame FROM gamevotes WHERE voteName = ?");
        $stmt->bind_param("s", $voteName);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            // Já votou
            $submitValue = "Voto atualizado!";
            $stmt->close();

            $stmt = $conn->prepare("UPDATE gamevotes SET votedGame = ? WHERE voteName = ?");
            $stmt->bind_param("ss", $novoVoto, $voteName);
            $stmt->execute();
        } else {
            // Ainda não votou
            $submitValue = "Obrigado!";
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO gamevotes (votedGame, voteName) VALUES (?, ?)");
            $stmt->bind_param("ss", $novoVoto, $voteName);
            $stmt->execute();
        }

        $stmt->close();
    }
}

// marcacao automatica dos botao
$stmt = $conn->prepare("SELECT votedGame FROM gamevotes WHERE voteName = ?");
$stmt->bind_param("s", $voteName);
$stmt->execute();
$stmt_result = $stmt->get_result();
if ($stmt_result->num_rows > 0) {
    $row = $stmt_result->fetch_assoc();
    $votedGame = $row['votedGame'];
}

$stmt->close();
$conn->close();
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
                        <li><a href="index">Home</a></li>
                        <?php
                            if (isset($_SESSION['PHPUsername'])) {
                                echo '<li><a href="gamevoting">Votação</a></li>';
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
                                echo '<a href="index"id="login">LOGIN</a>';
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
                    <form action="" method="post">
                        <div id="gamearea">
                            <label>
                                <input type="radio" name="votedGame" value="TSB" required
                                    <?= ($votedGame === 'TSB') ? 'checked' : '' ?>></input>
                                <img src="img/games/strongestBattlegrounds.jpg" alt="The Strongest Battlegrounds">
                            </label>
                            <label>
                                <input type="radio" name="votedGame" value="FL" 
                                    <?= ($votedGame === 'FL') ? 'checked' : '' ?>></input>
                                <img src="img/games/frontlines.jpg" alt="Frontlines">
                            </label>
                            <label>
                                <input type="radio" name="votedGame" value="NDS"
                                    <?= ($votedGame === 'NDS') ? 'checked' : '' ?>></input>
                                <img src="img/games/naturalDisaster.jpg" alt="Natural Disaster Survival">
                            </label>
                            <label>
                                <input type="radio" name="votedGame" value="LB2"
                                    <?= ($votedGame === 'LB2') ? 'checked' : '' ?>></input>
                                <img src="img/games/lumberTycoon.jpg" alt="Lumber Tycoon 2">
                            </label>
                        </div>
                        <br>
                        <input type="submit" id="botaovotar" value="<?= htmlspecialchars($submitValue)?>" 
                            style="padding: 8px 45.5%; text-align: center; background-color: #FFFFFF; border: 0px; color: #000000;">
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>