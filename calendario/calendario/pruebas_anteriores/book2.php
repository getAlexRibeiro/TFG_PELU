<?php 

$mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from bookings where date = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
    }
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $mysqli->prepare("select * from bookings where date = ?");
    $stmt->bind_param('s', $date);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            $msg = "<div class='alert alert-danger'>No disponible, hora ocupada</div>";
        }else{
            $stmt = $mysqli->prepare("INSERT INTO bookings (name, email, date) VALUES (?,?,?)");
            $stmt->bind_param('sss', $name, $email, $date);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Citado correctamente</div>";
            $stmt->close();
            $mysqli->close();
        }
    }
}

$stmt = $mysqli->prepare("select * from bookings where MONTH(date) = ? AND YEAR (date) = ?"); 
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


?>

<html>

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
  </head>

  <body>
    <div class="container">
        <h1 class="text-center">Cita para: <?php echo date('d/m/Y', strtotime($date)); ?></h1><hr>
        <div class="row">
           <div class="col-md-6 col-md-offset-3">
               <?php echo(isset($msg))?$msg:""; ?>
               <form action="" method="post">
                   <div class="form-group">
                       <label for="">Nombre</label>
                       <input required type="text" class="form-control" name="name">
                   </div>
                   <div class="form-group">
                       <label for="">Email</label>
                       <input required type="email" class="form-control" name="email">
                   </div>
                   <div class="form-group">
                       <button name="submit" type="submit" class="btn btn-primary">Pedir cita</button>
                   </div>
               </form>
           </div>

        </div>
        <center><h2><a href="calendar1.php">Volver</a>
        <a href="#">Productos</a></h2></center>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>

</html>