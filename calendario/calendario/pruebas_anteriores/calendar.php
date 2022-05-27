<?php
function crear_calendario($mes, $anio){
    // Primero creamos el array de los días de la semana.
    
    $diasSemana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');

    // Después tomamos el primer día del mes y ese es el argumento de esta función.

    $primerDiaMes = mktime(0,0,0,$mes,1,$anio);

    // Ahora tomamos la cantidad de días en el mes.

    $numeroDias = date('t',$primerDiaMes);

    // Información sobre el primer día de este mes.

    $infoDiaSemana = getdate($primerDiaMes);

    // Cogemos el nombre del mes.

    $nombreMes = $infoDiaSemana['mes'];

    // Cogemos el valor de 0 a 6 en el primer día de la semana.

    $DiaSemana = $infoDiaSemana['diaSem'];

    // Fecha actual

    $diaHoy = date('d-m-Y');

    // Ahora creamos la tabla html.

    $calendario = "<table class='table table-bordered'>";
    $calendario.= "<center><h2>$nombreMes $anio</h2></center>";

    $calendario.= "<tr>";

    // Creamos las cabeceras del calendario

    foreach($diasSemana as $diaHoy){
        $calendario.= "<th class='header'>$diaHoy</th>";
    }

    $calendario.= "</tr><tr>";

    // Nos aseguramos de que $diasSemana sean 7 columnas en la tabla.

    if($diasSemana > 0){
        for($k=0;$k<$diasSemana;$k++){
                $calendario.="<td></td>";
        }
    }

    // Iniciamos el contador de los días.

    $diaActual = 1;

    // Cogemos el número de mes.

    $mes=str_pad($mes,2,"0",STR_PAD_LEFT);

    while($diaActual <= $numeroDias){

        // Si la columna siete(Domingo) está creada, empezamos una nueva fila.

        if($DiaSemana == 7){
            $DiaSemana = 0;
            $calendario.= "</tr><tr>"
        } // Me sale error en esta línea y no entiendo el por qué, según el VS es el corchete de esta línea.

        $diaActualRel = str_pad($mes,2,"0",STR_PAD_LEFT);
        $date= "$diaActualRel/$mes/$anio";

        if($diaHoy == $date){
            $calendario.= "<td class='hoy'><h4>$diaActual</h4></td>";
        }else{
            $calendario.= "<td><h4>$diaActual</h4></td>";
        }

        $calendario.= "<td></td>"

    // Aumentamos los contadores.

        $diaActual++;

        $DiaSemana++;
    }

    // Completamos las filas con las semanas restantes del mes, si es necesario.

    if($DiaSemana != 7){
        $diasRestantes = 7-$DiaSemana;
        for($i=0;$i<$diasRestantes;$i++){
            $calendario.= "<td></td>";
        }
    }
    
    $calendario.= "</tr>"

    $calendario.= "</table>"

    echo $calendario.;
}

?>

<html>
<head>
    <meta name="viewport" content="width=devide-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootsrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
        table{
            table-layout: fixed;
        }
        td{
            width: 33%;
        }
        .hoy{
            background-color: #FB9680;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $infoDiaSemana =getdate();
                    $mes = $infoDiaSemana['mes'];
                    $anio = $infoDiaSemana ['año'];
                    echo crear_calendario($mes,$anio);
                ?>
            </div>
        </div>
    </div>
</body> 
</html>