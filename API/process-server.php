<?php

require_once("conn.php");
require_once("common.php");

$proctype = filter_input(INPUT_POST, "proctype");

if ($proctype == "callpass") {

    $var0 = filter_input(INPUT_POST, "senha");

    $var5 = filter_input(INPUT_POST, "guiche");

    if ((!isset($_SESSION["guiche"]) && $var5 != "") || (isset($_SESSION["guiche"]) && $var5 != $_SESSION["guiche"] && $var5 != "")) {

        $_SESSION["guiche"] = $var5;

    } else if (isset($_SESSION["guiche"]) && $var5 == "") {
        
        $var5 = $_SESSION["guiche"];

    } else {
        
        header("location: ../admin.php?error=0");
        return;

    }

    $var1 = file_get_contents("senhas.json", true);
    $var2 = json_decode($var1, true);

    $var3 = func02($var2, "senha", $var0)[0];

    // id
    $var4 = $var3["id"];

    $var6 = [
        "id" => $var3["id"],
        "nome_completo" => $var3["nome_completo"],
        "prioridade" => $var3["prioridade"],
        "tipo_atend" => $var3["tipo_atend"],
        "atend" => ["guiche" => $_SESSION["guiche"], "status" => "Atendendo"],
        "senha" => $var3["senha"]
    ];

    array_splice($var2, $var4, 1);
    array_unshift($var2, $var6);

    foreach ($var2 as $i => &$var7) {
        $var7["id"] = $i;
    }

    file_put_contents("senhas.json", json_encode($var2));

    header("location: ../admin.php");
}
