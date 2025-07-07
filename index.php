<?php
session_start();
require_once 'dataphp/dbconnection.php';

// área da tabela
$sql = "SELECT nome_completo, usuario FROM inscricoes";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Competição de Robux</title>
        <meta name="description" content="Competição de Robux do 2º REDES">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta charset="utf-8">

        <link rel="stylesheet" href="css/style.css">
        <script src="js/logo-and-sidebar.js" defer></script>
        <script src="js/name-verification.js" defer></script>
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
                                echo '<a href="login"id="login">LOGIN</a>';
                            }
                            ?>
                        </span>
                    </li>
                </ul>
            </nav>
        </aside>
        <div id="content">
            <header>
                <div id="presentation">
                    <img src="img/presentation.jpg" alt="background" id="animatedBackground">
                    <h1>COMPETIÇÃO DE ROBUX</h1>
                </div>
                <div id="intersection">
                    <h3>Imagine competindo por um prêmio de...</h3>
                    <h1 class="fontRainbow">5.000 ROBUX!</h1>
                </div>
            </header>
            <main id="background1">
                <img id="bloxy" src="img/bloxy.png" alt="BLOXY AWARD">
                <div class="container">
                    <section>
                        <h2>ISSO MESMO QUE OUVIU!</h2>
                        <p>
                            Nós do grupo [GAME] estamos propondo, neste ano de 2025,
                            uma competição especial de 5.000 ROBUX! <br>
                            Qualquer aluno no 2º ano do curso de TÉCNICO EM REDES
                            do Instituto Federal de São Paulo - Campus Pirituba pode participar!
                        </p> 
                    </section>

                    <section>
                        <h2>COMO PARTICIPAR?</h2>
                        <p>
                            Vá até o fim dessa página e se inscreva! <br>
                            Sem colocar seus amigos em segredo, eim! 
                        </p>
                    </section>

                    <section>
                        <h2 style="color: red">JÁ SE INSCREVEU?</h2>
                        <!--<form action="Verificacao()" method="POST"> -->
                            <label for="verificationName">Nome:</label>
                            <input type="text" id="verificationName" name="verificationName" maxlength="40" size="22" required>
                            <!--<input type="submit" value="OK">-->
                            <button onclick="Verification()">OK</button>
                            <h3 id="verificationResult"></h3>
                        <!-- </form> -->
                    </section>
                </div>

                <div class="container">
                    <section>
                        <h2>LISTA DE INSCRITOS:</h2>
                        <table id="inscriptionTable">
                            <tr>
                                <th>NOME</th>
                                <th>USUÁRIO</th>
                            </tr>
                            <?php if ($resultado && $resultado->num_rows > 0): ?>
                                <?php while($linha = $resultado->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(strtoupper($linha['nome_completo'])); ?></td>
                                        <td><?php echo htmlspecialchars(strtoupper($linha['usuario'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </table> 
                    </section>
                </div>
            </main>

            <footer>
                <div>
                    <a title="Clique para abrir a página de inscrição" href="inscription">
                        <?php
                        if (!isset($_SESSION['PHPUsername'])) {
                                echo '<h2>-> SE INSCREVA JÁ! <-</h2>';
                        }
                        ?>
                    </a>
                </div>
            </footer>
        </div>
    </body>
</html>