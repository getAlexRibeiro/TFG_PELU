<?php

$primerDiaMes = mktime(0,0,0,$mes,1,2021);


// Obtenemos el número del mes.
$mes = str_pad($mes,2,"0",STR_PAD_LEFT);

echo $primerDiaMes . " esto es el primer día del mes<br/>";
echo $mes . " esto es el mes";
?>