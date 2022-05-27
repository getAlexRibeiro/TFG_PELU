<?php

    function build_calendar($month, $year){

        $mysqli = new mysqli('localhost', 'root','', 'bookingcalendar');
        $stmt = $mysqli->prepare("select * from bookings where MONTH(date) = ? AND YEAR(date) = ?");
        $stmt->bind_param('ss', $month, $year);
        $bookings = array();
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()){
                    $bookings[] = $row['date'];
                }

                $stmt->close();
            }
        }

        // Creamos array con nombre de los días
        $daysOfWeek = array('Lunes', 'Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');

        // Tomámos el primer día del mes
        $firstDayOfMonth= mktime(0,0,0,$month,1,$year);

        // Tomámos el número de días del mes.
        $numberDays= date('t', $firstDayOfMonth);

        // Información sobre el primer día de este mes.
        $dateComponents = getdate($firstDayOfMonth);

        // Tomámos el nombre del mes.
        $monthName = $dateComponents['month'];

        // Tomámos valores de 0-6 para el primer día de este mes
        $dayOfWeek = $dateComponents['wday'];

        // Tomámos la fecha actual
        $dateToday = date('d-m-Y');

        // Creamos la tabla html
        $calendar = "<table class='table table-bordered'>";

        $calendar.= "<center><h2>$monthName $year</h2>";

        $calendar.="<a class='btn btn-xs brn-primary' href='?month=".date('m', mktime(0,0,0,$month-1,1,$year))."&year=".date('Y', mktime(0,0,0,$month-1,1,$year))."'>Mes anterior</a> ";

        $calendar.=" <a class='btn btn-xs brn-primary' href='?month=".date('m')."&year=".date('Y')."'>Mes actual</a> ";

        $calendar.="<a class='btn btn-xs brn-primary' href='?month=".date('m', mktime(0,0,0,$month+1,1,$year))."&year=".date('Y', mktime(0,0,0,$month+1,1,$year))."'>Mes siguiente</a><br>";

        $calendar.= "<tr>";

        // Creamos los headers del calendario
        foreach($daysOfWeek as $day){
            $calendar.="<th class='header'>$day</th>";
        }

        $calendar.="</tr><tr>";

        // Nos aseguramos de que la variable $dayOfWeek son 7 columnas
        if($dayOfWeek > 0){
            for($k=0;$k<$dayOfWeek;$k++){
                $calendar.="<td class='empty'></td>";
            }
        }

        // Iniciamos el contador de los días
        $currentDay =1 ;

        // Tomámos el numero del mes
        $month = str_pad($month,2,"0",STR_PAD_LEFT);

        while($currentDay <= $numberDays){

            // Si se completa la 7a columna, empezar otra
            if($dayOfWeek == 7){
                $dayOfWeek = 0;
                $calendar.="</tr><tr>";
            }

            $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
            $date = "$currentDayRel-$month-$year";
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today=$date==date('d-m-Y')?"today" : "";
            if($date<date('d-m-Y')){
                $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>No disponible</button>";
            }elseif(in_array($date, $bookings)){
                $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Ya citado</button>";
            }else{
                $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='book.php?date=".$date."' class='btn btn-success btn-xs'>Disponible</a>";
            }
            
            
            $calendar.="</td>";

            // Incrementamos los contadores
            $currentDay++;
            $dayOfWeek++;
        }

        // Completamos la fila  de la última semana del mes si es necesario
        if($dayOfWeek != 7){
        $remainingDays = 7-$dayOfWeek;
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


            }

            /* Smartphones (portrait and landscape) ----------- */

            @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
            }

            /* iPads (portrait and landscape) ----------- */

            @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
            }

            @media (min-width:641px) {
            table {
                table-layout: fixed;
            }
            td {
                width: 33%;
            }
            }

            .row{
            margin-top: 20px;
            }

            .today{
            background:#FDFCA2;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $dateComponents =getdate();
                        if(isset($_GET['month']) && isset($_GET['year'])){
                            $month=$_GET['month'];
                            $year=$_GET['year'];
                        }else{
                            $month = $dateComponents['mon'];
                            $year = $dateComponents['year'];
                        }
                        
                        echo build_calendar($month, $year);
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>