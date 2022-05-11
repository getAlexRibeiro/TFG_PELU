<?php
include 'conexion.php';
$errores = '';
$enviado = true;
// Comprobamos que el formulario haya sido enviado con las variables que hayamos puesto en index.view, deben llamarse igual!
if (isset($_POST['submit_login_admin'])) {

  $login_admin = $_POST['login_admin'];
  $login_admin_pass = $_POST['login_admin_pass'];

  if (!empty($login_admin)) { //comprabamos nombre login

    $login_admin = filter_var($login_admin, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto

  } else {
    $errores .= 'Por ingresa un nombre <br />';
    $enviado = false;
  }

  if (!empty($login_admin_pass)) { //comprobamos contraseña

    $login_admin_pass = filter_var($login_admin_pass, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto
  } else {
    $errores .= 'Por ingresa un nombre <br />';
    $enviado = false;
  }
  if ($enviado == false) { //lanzamos los errores que hayan podido ocurrir
    echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
  } else {
    // Comprobamos que el usuario existe
    $conexion = new mysqli("localhost", "root", "", "peluqueria");

    if ($conexion->connect_errno) {
      die('Lo siento hubo un problema con el servidor');
    } else {
      $consulta = mysqli_query($conexion, "SELECT * FROM clientes WHERE Nombre = '$login_admin' and password = '$login_admin_pass' and rol = 'admin'");
      if ($login_admin = mysqli_fetch_assoc($consulta)) {
        header("Location: ./crud/crud.php");
        exit;
      } else {
        echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
      }
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- IMPORTS HEADER BEGIN -->
  <?php include "includes/importHead.php"; ?>
  <!-- IMPORTS HEADER END -->
</head>

<body>

  <header class="header header-absolute">
    <!-- IMPORTS HEADER BEGIN -->
    <?php include "includes/importMenu.php"; ?>
    <!-- IMPORTS HEADER END -->

    <!-- Hero Section-->
    <section class="hero">
      <div class="container">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb justify-content-center">
          <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
          <li class="breadcrumb-item active">Acceso Admin</li>
        </ol>
        <!-- Hero Content-->
        <div class="hero-content pb-5 text-center">
          <h1 class="hero-heading mb-0">Acceso para administrador</h1>
        </div>
      </div>
    </section>
    <!-- customer login-->
    <section>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="block">
              <div class="form-group">
                <!---->
                </div>
                <div class="block-body">
                  <form action=" " name="formulario" method="post">
                    <div class="mb-4">
                      <label class="form-label" for="admin">Administrador</label>
                      <input type="text" placeholder="Cuenta administrador:" name="login_admin" id="login_admin">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="password">Contraseña</label>
                      <input type="password" placeholder="Contraseña Administrador:" name="login_admin_pass" id="login_admin_pass">
                    </div>
                    <div class="mb-4 text-center">
                      <input type="submit" name="submit_login_admin" class="btn btn-primary" value="Send"> <!-- boton para enviar los datos -->
                      <input type="reset" name="reset" class="btn btn-secundary" value="Reset">
                    </div>
                  </form>
                </div>
              </div>
            </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>


    <!-- IMPORTS FOOTER BEGIN -->
    <?php include "includes/importFooter.php"; ?>
    <!-- IMPORTS FOOTER END -->
    <!-- /Footer end-->
    <div id="scrollTop"><i class="fa fa-long-arrow-alt-up"></i></div>
    <!-- JavaScript files-->
</body>

</html>