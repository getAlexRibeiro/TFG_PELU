<?php
    //Incluimos conexión
    include '../conexion.php';

    //Obtener el id enviado de index
    $idBookings = $_GET['id'];

    //Seleccionar datos
    $query = "SELECT * FROM bookings where id_bookings='".$idBookings."'";
    $citas = mysqli_query($con, $query) or die (mysqli_error());

    //Volcamos los datos de ese registro en una fila
    $fila = mysqli_fetch_assoc($citas);



    if(isset($_POST['borrarCita'])){        

        //Validar si no están vacíos
        $query = "DELETE FROM bookings where id_bookings='$idBookings'";

            if(!mysqli_query($con, $query)){
                die('Error: ' . mysqli_error($con));
                $error = "Error, no se pudo crear el registros";
            }else{
                $mensaje = "Registro borrado correctamente";
                header('Location: ../crud/index.php');
                exit();
            }
    }   

?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link href="css/estilos.css" rel="stylesheet">

    <title>CRUD PHP Y MYSQL</title>
  </head>
  <body>
  <h1 class="text-center">CRUD PHP Y MYSQL</h1>
    <p class="text-center"> CRUD(Create, Read, Update, Delete)</p>
    <div class="container">

    <div class="row">
        <h4>Borrar una cita</h4>
    </div>
        <div class="row caja">
            <div class="col-sm-6 offset-3">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="id_bookings" class="form-label">ID Cita:</label>
                    <input type="text" class="form-control" name="id_bookings" placeholder="" value="<?php echo $fila['id_bookings']; ?>" readonly>                    
                </div>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre cliente citado:</label>
                    <input type="text" class="form-control" name="name" placeholder="Ingresa los password" value="<?php echo $fila['name']; ?>" readonly>                    
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Email:</label>
                    <input type="text" class="form-control" name="" placeholder="Ingresa los password" value="<?php echo $fila['name']; ?>" readonly>                    
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Date:</label>
                    <input type="text" class="form-control" name="" placeholder="Ingresa los password" value="<?php echo $fila['name']; ?>" readonly>                    
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Servicio:</label>
                    <input type="text" class="form-control" name="" placeholder="Ingresa los password" value="<?php echo $fila['name']; ?>" readonly>                    
                </div>
              
                <button type="submit" class="btn btn-primary w-100" name="borrarCita">Borrar Cita</button>

                </form>
            </div>
        </div>
    </div>
  </body>
</html>