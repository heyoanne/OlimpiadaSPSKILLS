<?php

require_once("conn.php");

// função para puxar os valores de uma array e contar a quantidade de valores iguais
function func01(array $var0, string $var1, string $var2)
{
    $var4 = 0;

    foreach ($var0 as $var3) {
        if ($var3[$var1] == $var2) {
            $var4++;
        }
    }

    return $var4;

}

// função para puxar os valores de uma array e retornar apenas os valores especificos
function func02(array $var0, string $var1, string $var2)
{
    $var1 = explode(".", $var1);

    $var4 = [];

    foreach ($var0 as $var3) {

        $var6 = $var3;

        foreach ($var1 as $var5) {

            if (isset($var6[$var5])) {
                $var6 = $var6[$var5];
            } else {
                $var6 = null;
                break;
            }
            
            if ($var6 == $var2) {
                $var4[] = $var3;
            }
        }
        
    }

    return $var4;

}
