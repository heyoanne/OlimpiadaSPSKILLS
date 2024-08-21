<!DOCTYPE html>
<html lang="en">

<?php

require_once("API/conn.php");

if (!isset($_SESSION["senha"])) {

    header("location: ../user.html");

}

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
            <img src="img/header.png" class="senai" />
            <div class="headerIcon">
                <img src="img/SENAI_São_Paulo_logo.png" id="headerLogo" />
            </div>
        </nav>
    </header>
    <!-- Final + Senha -->
    <div class="senha" id="formForSenha" style="">
        <h1 id="title_senha">Aguarde ser chamado(a)!</h1>

        <h5 id="subTitle_senha">Sua Senha:</h5>

        <h1 id="senha_output"><?= $_SESSION["senha"] ?></h1>

        <p id="subTitle_teste">
            *Tire um print ou permaneça na tela para não perder sua senha
        </p>
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