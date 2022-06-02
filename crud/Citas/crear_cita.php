<?php
    session_start();
    // Verificamos si ha iniciado sesión como admin o cliente 
    if (!isset($_SESSION["sname"])) {
        header("Location: ../../index.php");
    } else {
        //Incluimos conexión
        include '../../conexion.php'; 
    }

    if(isset($_POST['crearRegistro'])){


        $nombre_servicio = mysqli_real_escape_string($con, $_POST['nombre_servicio']);
        $precio_servicio = mysqli_real_escape_string($con, $_POST['precio_servicio']);

        // Verificamos si el tipo de archivo es un tipo de imagen permitido.
        // y que el tamaño del archivo no exceda los 16MB
        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 16384;


        //Configurar tiempo zona horaria
        date_default_timezone_set('DEFAULT');
        $time = date('h:i:s a', time());

        //Validar si no están vacíos
        if(!isset($nombre_servicio) || $nombre_servicio == '' || !isset($precio_servicio) || $precio_servicio == ''){
            $error = "Algunos campos están vacíos";
        }else if ((in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024)){

            // Archivo temporal
        $imagen_temporal = $_FILES['imagen']['tmp_name'];

        // Tipo de archivo
        $tipo = $_FILES['imagen']['type'];

        // Leemos el contenido del archivo temporal en binario.
        $fp = fopen($imagen_temporal, 'r+b');
        $data = fread($fp, filesize($imagen_temporal));
        fclose($fp);
        
        //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
        // $data=file_get_contents($imagen_temporal);

        // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
        $data = mysqli_real_escape_string($con, $data);

            $query = "INSERT INTO servicios(name_servicio, price_servicio, imagen_servicio, tipo_imagen )VALUES('$nombre_servicio', '$precio_servicio', '$data', '$tipo')";

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
    <p class="text-center"> CRUD(Create, Read, Update, Delete) Servicios</p>

    <div class="container">

    <div class="row">
        <h4>Crear un Nuevo Servicio</h4>
    </div>   

        <div class="row caja">

            <?php if(isset($error)) : ?>
                <h4 class="bg-danger text-white"><?php echo $error; ?></h4>
            <?php endif; ?>


            <div class="col-sm-6 offset-3">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre_servicio" class="form-label">Nombre Servicio:</label>
                    <input type="text" required class="form-control" name="nombre_servicio" placeholder="Ingresa el nombre del servicio">                    
                </div>
                
                <div class="mb-3">
                    <label for="precio_servicio" class="form-label">Precio de servicio:</label>
                    <input type="text" required class="form-control" name="precio_servicio" placeholder="Ingresa el precio">                    
                </div>

                <div class="mb-3">
                    <label for="imagen">Imagen:</label>
                    <input type="file" name="imagen" id="imagen" />
                </div>

                <button type="submit" class="btn btn-primary w-100" name="crearRegistro">Crear Servicio</button>

                </form>
            </div>
        </div>
    </div>
  </body>
</html>