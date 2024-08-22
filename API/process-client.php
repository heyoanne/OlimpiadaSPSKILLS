<?php

require_once("conn.php");
require_once("common.php");

$proctype = filter_input(INPUT_POST, "proctype");

if ($proctype == "generatepass") {

    if (isset($_SESSION["senha"])) {
        header("location: ../password.php");
        return;
    }

    // GERAR SENHA E PUXAR AS INFORMAÇÕES

    $var0 = filter_input(INPUT_POST, "atendimento");
    $var14 = filter_input(INPUT_POST, "prioridade");
    $var1 = ucfirst(filter_input(INPUT_POST, "nome"));
    $var2 = ucfirst(filter_input(INPUT_POST, "sobrenome"));

    $var3 = file_get_contents("senhas.json", true);
    $var4 = json_decode($var3, true);

    $var5 = substr($var0, 0, 1);

    $var6 = func01($var4, "tipo_atend", $var0) + 1;

    if ($var6 < 10 && $var6 < 100) {

        $var7 = "00";
    } else if ($var6 >= 10 && $var6 < 100) {

        $var7 = "0";
    } else {

        $var7 = "";
    }

    $var8 = $var5 . $var7 . $var6;

    // var8 é a senha gerada
    echo $var8;

    // definir os valores padrões
    $var9 = 0;
    $var10 = "Na fila";

    // id da senha
    $var11 = count($var4);

    // ____

    $var4[] = [
        "id" => $var11,
        "nome_completo" => $var1 . " " . $var2,
        "prioridade" => $var14,
        "tipo_atend" => $var0,
        "atend" => ["guiche" => $var9, "status" => $var10],
        "senha" => $var8
    ];

    $var13 = json_encode($var4);

    file_put_contents("senhas.json", $var13);

    $_SESSION["senha"] = $var8;

    header("location: ../password.php");
} else {
}
