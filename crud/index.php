<?php
session_start();

include '../conexion.php';
$errores = '';
$enviado = true;


// Login del administrador, que en caso de insertar datos de cliente nos lleva al calendario
if (isset($_POST['submit_login_admin'])) {

  $login_Nombre = $_POST['login_admin'];
  $login_Password = $_POST['login_admin_pass'];
  if (!empty($login_Nombre)) {
    //comprabamos nombre login
    $login_Nombre = filter_var($login_Nombre, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto
  } else {
    $errores .= 'Por ingresa un nombre <br />';
    $enviado = false;
  }

  if ($enviado == false) { //lanzamos los errores que hayan podido ocurrir
    echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
    header("Location: ./index.php");
  } else {
    // Verificamos problemas de conexión
    $conexion = new mysqli("localhost", "root", "", "peluqueria");
    if ($conexion->connect_errno) {
      die('Lo siento hubo un problema con el servidor');
      exit();
    } else {
      // En caso de que el usuario insertado sea un cliente nos redirecciona al indice
      if ($cliente = "SELECT * FROM CLIENTES WHERE NOMBRE = '$login_Nombre' AND ROL = 'cliente'") {
        $result = $conexion->query($cliente);
        if ($result->num_rows > 0) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $pass_hash = $row['password'];
          if (password_verify($login_Password, $pass_hash)) {
            $_SESSION["sname"] = 'cliente';
            header('Location: ../index.php');
          } else {
            echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
          }
        }
        // En caso de que el usuario insertado sea un administrador nos lleva al CRUD
        elseif ($cliente = "SELECT * FROM CLIENTES WHERE NOMBRE = '$login_Nombre' AND ROL = 'admin'") {
          $result = $conexion->query($cliente);
          if ($result->num_rows > 0) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $pass_hash = $row['password'];
            if (password_verify($login_Password, $pass_hash)) {
              $_SESSION["sname"] = 'admin';
              header('Location: ./crud.php');
            } else {
              echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
            }
          } else {
            echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
          }
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>


<body>

  <header class="header header-absolute">
    <!-- Hero Section-->
    <section class="hero">
      <div class="container">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb justify-content-center">
        </ol>
        <!-- Hero Content-->
        <div class="hero-content pb-5 text-center">
          <h1 class="hero-heading mb-0">Acceso para administrador</h1>
        </div>
      </div>
    </section>
    <!-- Admin login-->
    <section class="vh-100">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6 text-black">


            <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

              <form action=" " name="formulario" method="post" style="width: 23rem;">

                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

                <div class="form-outline mb-4">
                  <input type="text" name="login_admin" id="login_admin" placeholder="Usuario administrador" class="form-control form-control-lg" />

                </div>

                <div class="form-outline mb-4">
                  <input type="password" placeholder="Contraseña administrador" name="login_admin_pass" id="login_admin_pass" class="form-control form-control-lg" />
                </div>

                <div class="pt-1 mb-4">
                  <button type="submit" name="submit_login_admin" class="btn btn-secondary" type="button">Login</button>
                  <input type="reset" name="reset" class="btn btn-light" value="Limpiar">
                  <button class="btn btn-secondary"><a style="color: #ffffff; text-decoration: none; background-color: #6c757d;" href="../index.php">Volver a inicio</a></button>

                </div>
              </form>

            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- IMPORTS FOOTER BEGIN -->
    <!-- IMPORTS FOOTER END -->
    <!-- /Footer end-->
    <div id="scrollTop"><i class="fa fa-long-arrow-alt-up"></i></div>
    <!-- JavaScript files-->
</body>

</html>