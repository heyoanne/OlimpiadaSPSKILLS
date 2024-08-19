<?php

$var0 = filter_input(INPUT_POST, "atendimento");
$var1 = filter_input(INPUT_POST, "nome");
$var2 = filter_input(INPUT_POST, "sobrenome");

// var_dump($teste);

$var3 = substr($var0, 0, 1);

var_dump($var0);
var_dump($var3);

$var4 = file_get_contents("senhas.json");

$var5 = json_decode($var4);

var_dump($var5);

$var6 = count($var5) + 1;

var_dump($var6);