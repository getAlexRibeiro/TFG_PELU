<?php
// $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
function crear_calendario($month, $year){

    // Creamos un array con los días de la semana.
    $diasSemana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes','Sábado', 'Domingo');
    
    /*
    $mes = array("January" => "1" , "February" => "2" , "March" => "3" , "April" => "4" , "May" => "5" , "June" => "6" , "July" => "7" , "August" => "8" , "September" => "9" , "October" => "10" , "November" => "11" , "December" => "12");
    foreach($numeroMes as $numeroMes ){

    }*/

    // Obtenemos el primer día del mes que está en la función.
    $primerDiaMes = mktime(0,0,0,12,1,$year);

    // Obenemos el número de días del mes.
    $numeroDiasMes = date('t',$primerDiaMes);

    // Ahora obtenemos información sobre el primer día del mes.
    $informacionPrimerDiaMes = getdate($primerDiaMes);

    // Obtenemos el nombre del mes.
    $nombreMes = $informacionPrimerDiaMes['month'];

    // Obtenemos el valor de 0-6 del primer día del mes.
    $diaDeSemana = $informacionPrimerDiaMes['wday'];

    // Obtenemos la fecha actual.
    $fechaActual = date('d/m/Y');
    
    // Creamos la tabla de HTML .
    $calendario = "<table class='table table-bordered'>";
    $calendario.="<center><h2>$nombreMes $year</h2></center>";
    $calendario.="<tr>";
    $calendario.="<center><a class='btn btn-xs btn-primary' href='?month=".date('m',mktime(0,0,0,$month-1,1,$year))."&year=".date('Y',mktime(0,0,0,$month-1,1,$year))."'>Anterior Mes</a>   ";
    
    $calendario.=" <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Mes Actual</a> ";

    $calendario.="   <a class='btn btn-xs btn-primary' href='?month=".date('m',mktime(0,0,0,$month+1,1,$year))."&year=".date('Y',mktime(0,0,0,$month+1,1,$year))."'>Siguiente Mes</a></center><br>";

    /*$datetoday = date('d/m/Y'); 
    $calendario = "<table class='table table-bordered'>"; 
    $calendario.= "<center><h2>$nombreMes $year</h2>"; 
    $calendario.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $numeroMes-1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Anterior mes</button> "; 
    $calendario.= " <button class='changemonth btn btn-xs btn-primary' data-month='".date('m')."' data-year='".date('Y')."'>Mes Actual</button> "; 
    $calendario.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $numeroMes+1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Siguiente Mes</button></center><br>"; 
    $calendario.= "<tr>";*/
    

    // Creamos los headers del calendario.
    foreach($diasSemana as $Dia){
        $calendario.="<th class='header'>$Dia</th>";
    }

    // Iniciamos un contador de días.
    $diaHoy = 1;
    $calendario.="</tr><tr>";

    // La variable $diasSemana nos aseguramos que solo sean 7 columnas (Lunes-Domingo).
    if($diasSemana>0){
        for($k=0;$k<$diaDeSemana;$k++){
            $calendario.="<td class='empty'></td>";
        }
    }
    // Obtenemos el número del mes.
    // $month = str_pad(11,2,"0",STR_PAD_LEFT);

    // Si alcanzamos la séptima columna(Domingo), empezar una nueva fila.
    
    $diaHoyREL = str_pad($diaHoy,2,"0",STR_PAD_LEFT);
    while($diaHoy <= $numeroDiasMes){
        if ($diaDeSemana== 7) { 
            $diaDeSemana = 0; 
            $calendario .= "</tr><tr>"; 
        } 
        

        $diaHoyREL = str_pad($diaHoy, 2, "0", STR_PAD_LEFT); 
        $fecha = "$diaHoyREL-$month-$year"; 
        $nombreDia = strtolower(date('l', strtotime($fecha))); 
        $numEvento = 0; 
        $Hoy = $fecha==date('d/m/Y')? "hoy" : "";
        if($fecha<date('d/m/Y')){
            $calendario.="<td><h4>$diaHoy</h4><button class='btn btn-danger btn-xs'>No disponible</button>";
        }else{
            $calendario.="<td class='$Hoy'><h4>$diaHoy</h4><button class='btn btn-success btn-xs'>Disponible</button>";
        }



        $calendario.="</td>";
        // Incrementamos los contadores.
        $diaHoy++;
        $diaDeSemana++;
    }

    // Completamos la fila de la última semana del mes si es necesario.
    if($diasSemana != 7){
        $diasRestantes = 7- $diaDeSemana;
        for($i=0;$i<$diasRestantes;$i++){
            $calendario.="<td></td>";
        }
    }

    $calendario.="</tr>";
    $calendario.="</table>";

    echo $calendario;

}
?>




<html>
    <head>
        <meta name="viewport" content="widht=widht-device, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <style>
        @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr {
            display: block;

        }

        .empty {
            display: none;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        th {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            border: 1px solid #ccc;
        }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }



        /*
        Label the data
        */
        td:nth-of-type(1):before {
            content: "Lunes";
        }
        td:nth-of-type(2):before {
            content: "Martes";
        }
        td:nth-of-type(3):before {
            content: "Miércoles";
        }
        td:nth-of-type(4):before {
            content: "Jueves";
        }
        td:nth-of-type(5):before {
            content: "Viernes";
        }
        td:nth-of-type(6):before {
            content: "Sábado";
        }
        td:nth-of-type(7):before {
            content: "Domingo";
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
                
                $informacionPrimerDiaMes = getdate();
                $month = $informacionPrimerDiaMes['month'];
                $year = $informacionPrimerDiaMes['year'];
                echo crear_calendario(12,$year);
                                
                ?>
                </div>
            </div>
        </div>
<br><br><br>
        <h4>Cambiar en la línea de código: "echo crear_calendario(12,$year);" y en la línea: "$primerDiaMes = mktime(0,0,0,12,1,$year); el número 12"</h4>
    </body>
</html>