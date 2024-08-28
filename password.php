<!DOCTYPE html>
<html lang="en">

<?php

require_once("API/conn.php");

if (!isset($_SESSION["senha"])) {
    header("location: index.html");
}

// header('Refresh: 10; URL=http://yoursite.com/page.php');

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <nav class="navbar">
            <img src="img/SENAI_São_Paulo_logo.png" id="headerLogo" />
        </nav>
    </header>

    <!-- Final + Senha -->
    <div class="senha" id="formForSenha">
        <h1 id="title_senha">Aguarde ser chamado(a)!</h1>

        <p id="subTitle_senha">Sua Senha:</p>

        <h1 id="senha_output"><?= $_SESSION["senha"] ?></h1>

        <form action="index.html">
            <div class=""><button type="submit" class="finalizar_btn">Finalizar</button></div>
        </form>
    </div>
    <footer>
        <h2 class="footerDescription">
            Desenvolvido por
            <br />
            <label id="versão">Versão 0.1</label>
        </h2>
        <img src="img/logomasters.png" class="footerLogo" />
    </footer>
</body>

</html>

<!-- <script>

</script> -->