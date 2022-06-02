<?php
    session_start();
    // Verificamos si ha iniciado sesión como admin o cliente 
    if (!isset($_SESSION["sname"])) {
        header("Location: ../../index.php");
    } else {
        //Incluimos conexión
        include '../../conexion.php'; 
    }

    

    if(isset($_POST['crearCita'])){
        $nombre_cita = mysqli_real_escape_string($con, $_POST['nombre_cita']);
        $email_cita = mysqli_real_escape_string($con, $_POST['email_cita']);
        $date_cita = mysqli_real_escape_string($con, $_POST['date_cita']);
        $timeslot = mysqli_real_escape_string($con, $_POST['timeslot']);
        $servicio = mysqli_real_escape_string($con, $_POST['servicio']);
    

        //Configurar tiempo zona horaria
        date_default_timezone_set('DEFAULT');
        $time = date('h:i:s a', time());

        //Validar si no están vacíos
        if (!isset($nombre_cita) || $nombre_cita == '' || !isset($email_cita) || $email_cita == '' || !isset($date_cita) || $date_cita == '' || !isset($timeslot) || $timeslot == '') {
            $error = "Algunos campos están vacíos";
        } else {
            $query = "INSERT INTO bookings(name, email, date, timeslot, servicio)VALUES('$nombre_cita', '$email_cita', '$date_cita', '$timeslot', '$servicio')";

            if(!mysqli_query($con, $query)){
                die('Error: ' . mysqli_error($con));
                $error = "Error, no se pudo crear el registro";
            }else{
                $mensaje = "Registro creado correctamente";
                header('Location: ../crud.php');
                exit();
            }
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
    <p class="text-center"> CRUD(Create, Read, Update, Delete) Usuarios</p>

    <div class="container">

    <div class="row">
        <h4>Crear un Nuevo Registro</h4>
    </div>   

        <div class="row caja">

            <?php if(isset($error)) : ?>
                <h4 class="bg-danger text-white"><?php echo $error; ?></h4>
            <?php endif; ?>


            <div class="col-sm-6 offset-3">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                        <label for="nombre_cita" class="form-label">Cliente:</label>
                        <input type="text" required class="form-control" name="nombre_cita" placeholder="Ingresa el Cliente" value="">
                    </div>

                    <div class="mb-3">
                        <label for="email_cita" class="form-label">Email:</label>
                        <input type="text" required class="form-control" name="email_cita" placeholder="Ingresa la Email" value="">
                    </div>

                    <div class="mb-3">
                        <label for="date_cita" class="form-label">Fecha de la cita:</label>
                        <input type="date" required class="form-control" name="date_cita" placeholder="Ingresa la fecha de cita" >
                    </div>

                    <div class="mb-3">
                        <label for="timeslot" class="form-label">Horario cita:</label>
                        <input type="time" min="10:00" max="18:00" step="1800" required class="form-control" name="timeslot" placeholder="Ingresa el horario de la cita">
                    </div>

                    <div class="mb-3">
                        <label for="servicio" class="form-label">Servicio:</label>
                        <input type="text" required class="form-control" name="servicio" placeholder="Ingrese el servicio" >
                    </div>


                <button type="submit" class="btn btn-outline-secondary w-100" name="crearCita">Crear Cita</button>

                </form>
            </div>
        </div>
    </div>
  </body>
</html>