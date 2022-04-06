<!DOCTYPE html>
<?php include 'conexion.php'; ?>
<?php
$consulta_servicios= "SELECT * FROM servicios ORDER BY id_servicio asc";
$datos= mysqli_query ($con,$consulta_servicios);
?>

<html lang="en">
  <head>
  <!-- IMPORTS HEADER BEGIN -->
<?php include "includes/importHead.php"; ?>
  <!-- IMPORTS HEADER END -->
  </head>
  <body>

    
       <!-- IMPORTS HEADER BEGIN -->
<?php include "includes/importMenu.php"; ?>
  <!-- IMPORTS HEADER END -->
  
  <section class="py-6">
      <div class="container">
        <div class="row">
          <div class="col-xl-8 mb-5">
            <p class="text-uppercase text-muted fw-bold mb-1">Todos nuestros servicios</p>
            <p class="lead text-muted">Reserva tu cita solicitando el día y la hora que quieras en la sección de citas, escríbenos por Whastapp o llámanos sin compromiso para consultar cualquier duda que pueda surgirte</p>
          </div>
        </div>
        <?php while($fila=mysqli_fetch_array($datos)) : ?>
        <div class="row">
          <div class="col-md-4 mb-4 mb-md-6 pt-lg-3"><a href="custom-login.php"><img class="img-fluid" src="assets/img/photo/ejemplo_ambos.jpeg" alt="pelo adulto"></a>
            <div class="px-4 position-relative z-index-2 mt-n3"><a class="text-dark text-decoration-none" href="custom-login.php">
                <h3><?php echo $fila['name_servicio']; ?></h3>
                <p style="font-size: 20px;" class="text-muted"><?php echo $fila['price_servicio']; ?>€</p></a>
              <p> <a class="btn btn-link text-dark text-decoration-none px-0" href="custom-login.php"> Pedir Cita                      </a></p>
            </div>
          </div>
          <div class="col-md-7 ms-auto mb-4 mb-md-5">
            <div class="position-absolute z-index-5 py-6"><a class="text-dark text-decoration-none" href="custom-login.php">
                <h2><?php echo $fila['name_servicio']; ?></h2>
                <p style="font-size: 20px;" class="text-muted"><?php echo $fila['price_servicio']; ?>€</p></a>
              <p> <a class="btn btn-link text-dark text-decoration-none px-0" href="custom-login.php"> Pedir Cita                      </a></p>
            </div>
            <div class="ms-6"><a href="custom-login.php"><img class="img-fluid" src="assets/img/photo/ejemplo_niño.jpeg" alt="pelu niño"></a></div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-7 mb-4 mb-lg-5">
            <div class="position-absolute z-index-5 py-6"><a class="text-dark text-decoration-none" href="custom-login.php">
                <h2><?php echo $fila['name_servicio']; ?><br></h2>
                <p style="font-size: 20px;" class="text-muted"><?php echo $fila['price_servicio']; ?>€</p></a>
              <p> <a class="btn btn-link text-dark text-decoration-none px-0" href="custom-login.php"> Pedir Cita                      </a></p>
            </div>
            <div class="ms-6"><a href="custom-login.php"><img class="img-fluid" src="assets/img/photo/ejemplo_pelo.jpeg" alt="pelo joven"></a></div>
          </div>
          <?php endwhile; ?>        
      </div>

    </section>


<!-- IMPORTS FOOTER BEGIN -->
<?php include "includes/importFooter.php"; ?>
  <!-- IMPORTS FOOTER END -->