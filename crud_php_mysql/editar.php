<?php
    //Incluimos conexión
    include 'conexion.php';

    //Obtener el id enviado de index
    $idRegistro = $_GET['id'];

    //Seleccionar datos
    $query = "SELECT * FROM clientes where id='".$idRegistro."'";
    $clientes = mysqli_query($con, $query) or die (mysqli_error());

    //Volcamos los datos de ese registro en una fila
    $fila = mysqli_fetch_assoc($clientes);



    if(isset($_POST['editarRegistro'])){
        $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
        $password = mysqli_real_escape_string($con, $_POST['password']);


        //Configurar tiempo zona horaria
        date_default_timezone_set('America/Bogota');
        $time = date('h:i:s a', time());

        //Validar si no están vacíos
        if(!isset($nombre) || $nombre == '' || !isset($password) || $password == '' ){
            $error = "Algunos campos están vacíos";
        }else{
            $query = "UPDATE clientes set nombre='$nombre', password='$password' where id='$idRegistro'";

            if(!mysqli_query($con, $query)){
                die('Error: ' . mysqli_error($con));
                $error = "Error, no se pudo crear el registros";
            }else{
                $mensaje = "Registro editado correctamente";
                header('Location: crud.php');
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
    <p class="text-center"> CRUD(Create, Read, Update, Delete)</p>
    <div class="container">

    <div class="row">
        <h4>Editar un Registro Existente</h4>
    </div>


        <div class="row caja">

            <?php if(isset($error)) : ?>
                <h4 class="bg-danger text-white"><?php echo $error; ?></h4>
            <?php endif; ?>

            <div class="col-sm-6 offset-3">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre" value="<?php echo $fila['nombre']; ?>">                    
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">password:</label>
                    <input type="text" class="form-control" name="password" placeholder="Ingresa la password" value="<?php echo $fila['password']; ?>">                    
                </div>

                <button type="submit" class="btn btn-primary w-100" name="editarRegistro">Editar Registro</button>

                </form>
            </div>
        </div>
    </div>
  </body>
</html>