<?php

function build_calendar($month, $year){

    // Creamos un array con los días de la semana.
    $daysOfWeek = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes','Sábado', 'Domingo');

    // Obtenemos el primer día del mes que está en la función.
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    // Obenemos el número de días del mes.
    $numberDays = date('t',$firstDayOfMonth);

    // Ahora obtenemos información sobre el primer día del mes.
    $dateComponents = getdate($firstDayOfMonth);

    // Obtenemos el nombre del mes.
    $monthName = $dateComponents['month'];

    // Obtenemos el valor de 0-6 del primer día del mes.
    $dayOfWeek = $dateComponents['wday'];

    // Obtenemos la fecha actual.
    $dateToday = date('d/m/Y');
    
    // Creamos la tabla de HTML .
    $calendar = "<table class='table table-bordered'>";
    $calendar.="<center><h2>$monthName $year</h2></center>";

    $calendar.="<tr>";

    // Creamos los headers del calendario.
    foreach($daysOfWeek as $day){
        $calendar.="<th class='header'>$day</th>";
    }

    $calendar.="</tr><tr>";

    // La variable $daysOfWeek nos aseguramos que solo sean 7 columnas (Lunes-Domingo).
    if($daysOfWeek>0){
        for($k=0;$k<$dayOfWeek;$k++){
            $calendar.="<td></td>";
        }
    }

    // Iniciamos un contador de días.
    $currentDay = 1;

    // Obtenemos el número del mes.
    $month = str_pad($month,2,"0",STR_PAD_LEFT);

    // Si alcanzamos la séptima columna(Domingo), empezar una nueva fila.
    if($dayOfWeek == 7){
        $dayOfWeek = 0;
        $calendar.="</tr><tr>";
    }

    while($currentDay <= $numberDays){
        $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
        $date = "$currentDayRel/$month/$year";

        if($dateToday==$date){
            $calendar.="<td class='today'><h4>$currentDay</h4>";
        }else{
            $calendar.="<td><h4>$currentDay</h4>";
        }

        $calendar.="</td>";

        // Incrementamos los contadores.
        $currentDay++;
        $dayOfWeek++;
    }

    // Completamos la fila de la última semana del mes si es necesario.
    if($daysOfWeek != 7){
        $remainingDays = 7- $dayOfWeek;
        for($i=0;$i<$remainingDays;$i++){
            $calendar.="<td></td>";
        }
    }

    $calendar.="</tr>";
    $calendar.="</table>";

    echo $calendar;

}



?>




<html>
    <head>
        <meta name="viewport" content="widht=widht-device, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <style>
         table{
             table-layout: fixed;
         }
         td{
             width: 33%;
         }
         .today{
             background-color: #FB9680;
         }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <?php 
                
                $dateComponents = getdate();
                $month = $dateComponents['month'];
                $year = $dateComponents['year'];
                echo build_calendar($month,$year);
                
                
                ?>
                </div>
            </div>
        </div>
    </body>
</html>