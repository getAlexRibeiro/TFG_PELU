<?php
include 'conexion.php';
if (isset($_POST['submit'])) {
	$Nombre = $_POST['nombre'];
	$Password= $_POST['password'];
	$Email = $_POST['email'];


if (isset($_POST['submit_login'])) {

$login_Nombre = $_POST['login_Nombre'];
$login_Password = $_POST['login_Password'];

if (!empty($login_Nombre)) { //comprabamos nombre login

    $login_Nombre = filter_var($login_Nombre, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto

} else {
    $errores .= 'Por ingresa un nombre <br />';
    $enviado = false;
}

if (!empty($login_Password)) { //comprobamos contraseña

    $login_Password = filter_var($login_Password, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto

} else {
    $errores .= 'Por ingresa un nombre <br />';
    $enviado = false;
}


if ($enviado == false) { //lanzamos los errores que hayan podido ocurrir
    echo "Error";
} else {
    // Comprobamos que el usuario existe
    $conexion = new mysqli("localhost", "root", "", "peluqueria");

    if ($conexion->connect_errno) {
        die('Lo siento hubo un problema con el servidor');
    } else {


        $consulta = mysqli_query($conexion, "SELECT * FROM clientes WHERE Nombre = '$login_Nombre'");

        // esto válida si la consulta se ejecuto correctamente o no
        // pero en ningún caso válida si devolvió algún registro
        if (!$consulta) {
            echo "Usuario no existe " . $nombre . " " . $password. " o hubo un error "; 
            // si la consulta falla es bueno evitar que el código se siga ejecutando
            exit;
        }
        
        // validemos pues si se obtuvieron resultados 
        // Obtenemos los resultados con mysqli_fetch_assoc
        // si no hay resultados devolverá NULL que al convertir a boleano para ser evaluado en el if será FALSE
        if ($login_Nombre = mysqli_fetch_assoc($consulta)) {
        //sleep(3); //Damos unos segundos para redireccionar

            header("Location: ./calendario/calendario.php");
            exit;
        } else {
            echo " Usuario incorrecto o no existe";
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
          <li class="breadcrumb-item active">Bienvenido</li>
        </ol>
        <!-- Hero Content-->
        <div class="hero-content pb-5 text-center">
          <h1 class="hero-heading mb-0">Bienvenido</h1>
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
                <div class="block-header">
                  <h6 class="text-uppercase mb-0">Acceso</h6>
                </div>
                <div class="block-body">
                  <p class="lead">¿Ya registrado?</p>
                  <p class="text-muted"></p>
                  <hr>
                  <form action=" " name="formulario" method="post">
                    <div class="mb-4">
                      <label class="form-label" for="email1">Nombre Usuario</label>
                      <input type="text" placeholder="Nombre de usuario:" name="login_Nombre" id="login_Nombre">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="password1">Contraseña</label>
                      <input type="password" placeholder="Contraseña:" name="login_Password" id="login_Password">
                    </div>
                    <div class="mb-4 text-center">
                      <input type="submit" name="submit_login" class="btn btn-primary" value="Send"> <!-- boton para enviar los datos -->
                      <input type="reset" name="reset" class="btn btn-secundary" value="Reset">
                    </div>
                  </form>
                </div>
              </div>
            </div>

 