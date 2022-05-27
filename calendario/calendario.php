<?php

function build_calendar($month, $year) {
    include '../conexion.php';
    $consulta_servicios = "SELECT * FROM servicios ORDER BY id_servicio ASC";
    $datos = mysqli_query($con, $consulta_servicios);
       
    
    // Creamos array con nombre de los días
     $daysOfWeek = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');

    // Tomámos el primer día del mes
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    // Tomámos el número de días del mes.
     $numberDays = date('t',$firstDayOfMonth);

    // Información sobre el primer día de este mes.
     $dateComponents = getdate($firstDayOfMonth);

    // Tomámos el nombre del mes.
    $monthName = $dateComponents['month'];

    // Tomámos valores de 0-6 para el primer día de este mes
     $dayOfWeek = $dateComponents['wday'];
     if($dayOfWeek == 0){
        $dayOfWeek =6;
     }else{
         $dayOfWeek = $dayOfWeek-1;
     }

    // Creamos la tabla html y headers para los días de la semana
    $datetoday = date('Y-m-d');
    
    
    
    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Mes Anterior</a> ";
    
    $calendar.= " <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Mes Actual</a> ";
    
    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Siguiente Mes</a></center><br>";

    /*$calendar.= "<center><label for=''>Servicio </label><select name='servicio'>"

            ?>
            <?php while($fila=mysqli_fetch_array($datos,MYSQLI_ASSOC)):?><?php

    $calendar.= "<option value=''>$fila[name_servicio]</option>";;

            
            ?><?php /*if($fila=['name_servicio']=="Cortar Pelo y Barba"){
                    

            }
            *//*
                endwhile;?><?php


    $calendar.= "</select></center>";
    
    */
        
    $calendar .= "<tr>";

    // Creamos los headers del calendario

     foreach($daysOfWeek as $day) {
          $calendar .= "<th  class='header'>$day</th>";
     } 

    // Creamos el resto del calendario

    // Iniciamos el contador del día, empieza en 1

     $currentDay = 1;

     $calendar .= "</tr><tr>";

    // La variable $dayOfWeek sirve para asegurarnos de que hay 7 columnas

     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td class='empty'></td>"; 

         }
     }
    
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

        // Cuando llegamos a la columna siete, empezamos otra fila

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          $date = "$year-$month-$currentDayRel";
          
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
            if($dayname=='sunday'){
                $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Cerrado</button>";
            }elseif($date<date('Y-m-d')){
             $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>No disponible</button>";
            }else{

            // Tenemos entre semana 16 slots libres.
            $totalbookings = checkSlots($con,$date);
            if($totalbookings==16){
                $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='#' class='btn btn-danger btn-xs'>Todo ocupado</a>";
            }else{
                $avaiableslots = 16 - $totalbookings;
                $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='book.php?date=".$date."' class='btn btn-success btn-xs'>Disponible</a> <span style='font-size:11px;'><i>$avaiableslots citas</i></span>";
            }

            
             
            }

        
           
            
          $calendar .="</td>";
        // Incrementamos los contadores
 
          $currentDay++;
          $dayOfWeek++;

     }
     
     

    // Completamos la fila del último mes en caso de ser necesario

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty'></td>"; 

         }

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     echo $calendar;

}

function checkSlots($con,$date){
    $stmt = $con->prepare("select * from bookings where date = ? ");
    $stmt->bind_param('s', $date);
    $totalbookings = 0;
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $totalbookings++;
            }
            
            $stmt->close();
        }
    }
    return $totalbookings;
}





?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
       @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Forzamos a que las tablas no sean tablas en estos tamaños */
            table, thead, tbody, th, td, tr {
                display: block;

            }
            

            .empty {
                display: none;
            }

            /* Ocultamos los headers sin usar display:none; para una mayor accesibilidad */
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


            /* Datos de etiquetas */
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

        /* Telefonía y móvil -------- */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        /* iPads -------------------- */

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

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                     $dateComponents = getdate();
                     if(isset($_GET['month']) && isset($_GET['year'])){
                         $month = $_GET['month']; 			     
                         $year = $_GET['year'];
                     }else{
                         $month = $dateComponents['mon']; 			     
                         $year = $dateComponents['year'];
                     }
                    echo build_calendar($month,$year);
                ?>
            </div>
        </div>
    </div><br>
    <div class="form-group">
        <center><button><a href="../index.php">Volver al inicio</a></button></center>
    </div>
        
</body>

</html>