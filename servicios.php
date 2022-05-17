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

  <div class="container">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb justify-content-center">
          <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
          <li class="breadcrumb-item active">Servicios</li>
        </ol>
        <!-- Hero Content-->
        <div class="hero-content pb-5 text-center">
          <h1 class="hero-heading">Servicios</h1>
          <div class="row">   
          </div>
        </div>
      </div>
    
  <div class="album py-5 bg-light">
    <div class="container ">

      <div>
        <div class="row ">
        <?php while($fila=mysqli_fetch_array($datos)) : ?>
          <div class="card shadow-sm col-md-4 col-sm-4" >
            <img class="img-fluid d-flex justify-content-between align-items-center" width="100%" height="100%" src="data:image/jpeg;base64,<?php echo  base64_encode($fila['imagen_servicio']); ?>" alt="<?php echo $fila['name_servicio']; ?>€">
            <div class="card-body">
              <h3><?php echo $fila['name_servicio']; ?></h3>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary"><a href="custom-login.php"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Pedir cita</font></font></a></button>
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