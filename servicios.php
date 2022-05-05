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


    
  <div class="album py-5 bg-light">
    <div class="container ">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="row ">
        <?php while($fila=mysqli_fetch_array($datos)) : ?>
          <div class="card shadow-sm">
            <img class="img-fluid d-flex justify-content-between align-items-center" src="assets/img/photo/ejemplo_ambos.jpeg" alt="pelo adulto">

            <div class="card-body">
              <h3><?php echo $fila['name_servicio']; ?></h3>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Pedir cita</font></font></button>
                </div>
                <small class="text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $fila['price_servicio']; ?>€</font></font></small>
              </div>
            </div>
          </div>
          <?php endwhile; ?> 
        </div>
    </div>
  </div>
  

<!-- IMPORTS FOOTER BEGIN -->
<?php include "includes/importFooter.php"; ?>
  <!-- IMPORTS FOOTER END -->