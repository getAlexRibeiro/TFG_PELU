<?php include './conexion.php'; ?>
<?php
    //Crear y seleccionar query
    $query_cliente = "SELECT * FROM clientes ORDER BY id_cliente asc";
    $usuarios = mysqli_query($con, $query_cliente);
    $query_servicio = "SELECT * FROM servicios ORDER BY id_servicio asc";
    $servicios = mysqli_query($con, $query_servicio);
    $query_citas = "SELECT * FROM bookings ORDER BY id_bookings asc";
    $citas = mysqli_query($con, $query_citas);
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

    <title>CRUD Famosso Barber</title>
  </head>
  
  <script type="text/javascript">
         function showHideDiv(ele) {
         	var srcElement = document.getElementById(ele);
         	if (srcElement != null) {
         		if (srcElement.style.display == 'none') {
         			srcElement.style.display = 'block';
         		}
         		else {
         			srcElement.style.display = 'none';
         		}
         		return false;
         	}
         }
      </script>
  <body>
  <h1 class="text-center">CRUD Famosso Barber</h1>
  <br>

    <center><input type="button" class="btn btn-primary btn-lg btn-block" value="Tabla Clientes" onClick="showHideDiv('divMsg')"/> </center><br><br>
    <div style="display: none; class="container" id = 'divMsg'>
        <?php if(isset($_GET['mensaje'])) : ?>                
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['mensaje']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-4 offset-8">
                <a href="./Clientes/crear.php" class="btn btn-success w-100">Crear Nuevo Cliente</a>
            </div>            
        </div>
        <div class="row caja">
            <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Accion</th>
                        </tr>   
                    </thead>
                    <tbody>

                        <?php while($fila_cliente = mysqli_fetch_assoc($usuarios)) : ?>
                        <tr>
                            <td><?php echo $fila_cliente['id_cliente']; ?></td>
                            <td><?php echo $fila_cliente['nombre']; ?></td>
                            <td><?php echo $fila_cliente['email']; ?></td>
                            <td><?php echo $fila_cliente['password']; ?></td>
                            <td>
                            <a href="./Clientes/editar.php?id=<?php echo $fila_cliente['id_cliente']; ?>" class="btn btn-primary"> Editar</a>
                            <a href="./Clientes/borrar.php?id=<?php echo $fila_cliente['id_cliente']; ?>" class="btn btn-danger"> Borrar</a>
                            </td>
                        </tr> 

                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <!-- Tabla Servicios --> 
    <center><input type="button" class="btn btn-primary btn-lg btn-block" value="Tabla Servicios" onClick="showHideDiv('divMsg2')"/> </center><br><br>
    <div style="display: none; class="container" id = 'divMsg2'>
        <?php if(isset($_GET['mensaje'])) : ?>                
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['mensaje']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-4 offset-8">
                <a href="./Servicios/crear_servicio.php" class="btn btn-success w-100">Crear Nuevo Servicio</a>
            </div>            
        </div>
        <div class="row caja">
            <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Servicio</th>
                            <th>Precio</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($fila_servicio = mysqli_fetch_assoc($servicios)) : ?>
                        <tr>
                            <td><?php echo $fila_servicio['id_servicio']; ?></td>
                            <td><?php echo $fila_servicio['name_servicio']; ?></td>
                            <td><?php echo $fila_servicio['price_servicio']; ?></td>
                            <td>
                            <a href="./Servicios/editar_servicio.php?id=<?php echo $fila_servicio['id_servicio']; ?>" class="btn btn-primary"> Editar</a>
                            <a href="./Servicios/borrar_servicio.php?id=<?php echo $fila_servicio['id_servicio']; ?>" class="btn btn-danger"> Borrar</a>
                            </td>
                        </tr> 

                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <!-- Tabla Citas --> 
    <center><input type="button" class="btn btn-primary btn-lg btn-block" value="Tabla Citas" onClick="showHideDiv('divMsg1')"/> </center><br><br>
    <div style="display: none; class="container" id = 'divMsg1'>
        <?php if(isset($_GET['mensaje'])) : ?>                
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['mensaje']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
            </div>            
        </div>
        <div class="row caja">
            <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre cliente citado</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Timeslot</th>
                            <th>Servicio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila_citas = mysqli_fetch_assoc($citas)) : ?>
                        <tr>
                            <td><?php echo $fila_citas['id_bookings']; ?></td>
                            <td><?php echo $fila_citas['name']; ?></td>
                            <td><?php echo $fila_citas['email']; ?></td>
                            <td><?php echo $fila_citas['date']; ?></td>
                            <td><?php echo $fila_citas['timeslot']; ?></td>
                            <td><?php echo $fila_citas['servicio']; ?></td>
                            <td>
                            <a href="./Citas/borrar_cita.php?id=<?php echo $fila_citas['id_bookings']; ?>" class="btn btn-danger"> Borrar</a>
                            </td>
                        </tr> 
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->

  </body>
</html>