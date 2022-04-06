<?php
$con = new mysqli('localhost', 'root', '', 'peluqueria');
$consulta_servicios = "SELECT * FROM servicios ORDER BY id_servicios ASC";
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
        if($result->num_rows>0){

            $msg = "<div class='alert alert-danger'>Ocupado</div>";
        }else{
            $stmt = $con->prepare("INSERT INTO bookings (name, timeslot, email, date, servicio) VALUES (?,?,?,?,?)");
            $stmt->bind_param('sssss', $name, $timeslot, $email, $date, $servicio);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Citado correctamente</div>";
            $bookings[] = $timeslot;
            $stmt->close();
            $con->close();
        }
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

        $slots[] = $intStart->format("H:i A")." - ".$endPeriod->format("H:i A");
    }
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
        <center><button><a href="calendario.php">Volver al calendario</a></button></center>
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
                                    <input required type="text"  name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Servicio</label>
                                    <select name="Servicios">
                                    <?php while($fila = mysqli_fetch_array($datos, MYSQLI_ASSOC)) : ?>

                                        <option value="<?php echo $fila["id_servicios"];
                                            // The value we usually set is the primary key
                                        ?>">
                                            <?php echo $fila["name_servicio"];
                                                // To show the category name to the user
                                            ?>
                                        </option>
                                    <?php endwhile; ?>    
                                    </select>
                        
                                        

                                    
                                    
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

<!-- Crear tabla en localhost por si da problemas en el server.

    CREATE TABLE `bookings` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `date` date NOT NULL,
 `name` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `timeslot` VARCHAR(255) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-->