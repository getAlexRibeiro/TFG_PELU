<?php

session_start();
// Verificamos si ha iniciado sesión como admin o cliente 
if (!isset($_SESSION["sname"])) {
    header("Location: ../index.php");
} else {
    //Incluimos conexión
    include '../conexion.php'; 
}

include '../conexion.php';
$consulta_servicios = "SELECT * FROM servicios ORDER BY id_servicio ASC";
$datos = mysqli_query($con, $consulta_servicios);


if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $con->prepare("select * from bookings where date = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            
            $stmt->close();
        }
    }
}



if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $timeslot = $_POST['timeslot'];
    $servicio = $_POST['servicio'];
    $stmt = $con->prepare("select * from bookings where date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $timeslot);
    if($stmt->execute()){
        $result = $stmt->get_result();
        
        if(($timeslot=="17:30 - 18:00")&&($servicio=="Corte Pelo y Barba")){
            echo "<script type='text/javascript'>alert('No puede reservar cita del servicio Corta de Pelo y Barba en la franja horaria `17:30-18:00`.');</script>";
            
        }elseif($result->num_rows>0){

            $msg = "<div class='alert alert-danger'>Ocupado</div>";
        // Añadimos un if y que si intenta pedir una cita a las ultima hora del servicio 3, salte un mensaje de error.
        }else{
            $stmt = $con->prepare("INSERT INTO bookings (name, timeslot, email, date, servicio) VALUES (?,?,?,?,?)");
            $stmt->bind_param('sssss', $name, $timeslot, $email, $date, $servicio);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Citado correctamente</div>";
            $bookings[] = $timeslot;
        }
        
        if($timeslot=="17:30 - 18:00"){
                                        
                    
                    //echo "<script type='text/javascript'>alert('No puede reservar cita del servicio Corta de Pelo y Barba en la franja horaria `17:30-18:00`. Se le //redireccionará al calendario para que elija de nuevo día y hora.');</script>";
//
//
                    //header("Location: ./index.php");
                }

            # Creamos un if para que cuando se seleccione el servicio de corte pelo y barba, se añada 30 minutos a la duración y nos coja dos slots de tiempo en vez de uno.
            elseif($servicio=="Corte Pelo y Barba"){
                $duration = 30;
                $cleanup = 0;
                $startTimeslot = substr($timeslot,-5,5); 
                $endTs1 = substr($startTimeslot,-5,2); 
                $endTs2 = substr($startTimeslot,-2,2);

                  if($endTs2==30){
                      $endTs1 = intval($endTs1) + 1;
                      $endTs2 = "00";
                  }else{
                      $endTs2 = 30;
                  }

                $endTimeslot= strval($endTs1) . ":" . $endTs2;
                $timeslot2 = strval($startTimeslot . " - " . $endTimeslot);
                $stmt = $con->prepare("INSERT INTO bookings (name, timeslot, email, date, servicio) VALUES (?,?,?,?,?)");
                $stmt->bind_param('sssss', $name, $timeslot2, $email, $date, $servicio);
                $stmt->execute();
                $msg = "<div class='alert alert-success'>Citado correctamente</div>";
                $bookings[] = $timeslot2;
            
            }
            
            $stmt->close();
            $con->close();
            
        }

    }
    


$duration = 30;
$cleanup = 0;
$start = "10:00";
$end = "18:00";
// $endSaturday = "14:00";



function timeslots($duration,$cleanup,$start,$end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    for($intStart = $start; $intStart<$end;$intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }

        $slots[] = $intStart->format("H:i")." - ".$endPeriod->format("H:i");
    }
//print_r($slots);
    return $slots;
}

?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <style>
        a:hover{text-decoration:none;}
    </style>
  </head>

  <body>
    <div class="container">
        <h1 class="text-center">Horas para coger cita del día : <?php echo date('d/m/Y', strtotime($date)); ?></h1><hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($msg)?$msg:""; ?>
            </div>
            <?php $timeslots = timeslots($duration,$cleanup,$start,$end);
            foreach($timeslots as $ts){
             ?>   
            
            <div class="col-md-2">
                <div class="form-group">
                    <?php if(in_array($ts,$bookings)){?>
                        <button class="btn btn-danger"><?php echo $ts; ?></button>
                    <?php }else{ ?>
                        <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                    <?php } ?>
                </div>
            </div>
            
           <?php } ?>
        </div>
    </div>
    <br><br><br>
    <div class="form-group">
    <center><a class='btn btn-outline-warning' style="color: #ffffff; text-decoration: none; background-color: #6c757d;" href="index.php">Volver al calendario</a></center>
    </div>
    <div class="form-group">
    <center><a class='btn btn-outline-warning' style="color: #ffffff; text-decoration: none; background-color: #6c757d;" href="../index.php">Volver al inicio</a></center>
    </div>


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cita para el día <?php echo date('d/m/Y', strtotime($date)); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Hora de la cita</label>
                                    <input required type="text" readonly name="timeslot" id="timeslot">
                                </div>
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input required type="text"  name="name" class="form-control" value="<?php echo $_SESSION['sname'];?> ">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="email" name="email" class="form-control" value="<?php echo $_SESSION['semail'];?> ">
                                </div>
                                <div class="form-group">
                                    <label for="">Servicio</label>
                                    <select name="servicio">
                                    <?php while($fila = mysqli_fetch_array($datos, MYSQLI_ASSOC)) : ?>

                                        <option value="<?php echo $fila["name_servicio"];
                                            // The value we usually set is the primary key
                                        ?>">
                                            <?php echo $fila["name_servicio"];

                                    
                                                // To show the category name to the user
                                            ?>
                                        </option>
                                    <?php endwhile; ?>    
                                    </select>
                                    <br><small><strong>* Si seleccionas la opción 'Cortar Pelo y Barba' y reservas cita, automaticamente se te reservará la franja horaria seleccionada y la siguiente; a excepción de la última cita 17:30 - 18:00 .</strong></small>
                        
                                </div>
                                <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="submit">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
        $(".book").click(function(){
            var timeslot =$(this).attr('data-timeslot');
            $("#slot").html(timeslot);
            $("#timeslot").val(timeslot);
            $("#myModal").modal("show");

        })
    </script>
  </body>

</html>
