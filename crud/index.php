<?php
session_start();

include '../conexion.php';
$errores = '';
$enviado = true;


// Login del administrador, que en caso de insertar datos de cliente nos lleva al calendario
if (isset($_POST['submit_login_admin'])) 
{

  $login_Nombre = $_POST['login_admin'];
  $login_Password = $_POST['login_admin_pass'];
  if (!empty($login_Nombre)) 
    {
      //comprabamos nombre login
      $login_Nombre = filter_var($login_Nombre, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto
    } 
    else 
      {
        $errores .= 'Por ingresa un nombre <br />';
        $enviado = false;
      }

  if ($enviado == false) 
  { //lanzamos los errores que hayan podido ocurrir
    echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
    header("Location: ./index.php");
  } else 
  {
    // Verificamos problemas de conexión
    $conexion = new mysqli("localhost", "root", "", "peluqueria");
      if ($conexion->connect_errno) 
        {
          die('Lo siento hubo un problema con el servidor');
          exit();
        } 
        else 
        {
          // En caso de que el usuario insertado sea un cliente nos redirecciona al indice
          if($cliente = "SELECT * FROM CLIENTES WHERE NOMBRE = '$login_Nombre' AND ROL = 'cliente'") 
          {
            $result = $conexion->query($cliente);
              if($result->num_rows>0) 
              {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $pass_hash = $row['password'];
                if(password_verify($login_Password, $pass_hash)) 
                {
                    $_SESSION["sname"] = 'cliente';
                    header('Location: ../index.php');
                } else 
                {
                  echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
                }
              } 
              // En caso de que el usuario insertado sea un administrador nos lleva al CRUD
              elseif ($cliente = "SELECT * FROM CLIENTES WHERE NOMBRE = '$login_Nombre' AND ROL = 'admin'") 
              {
              $result = $conexion->query($cliente);
                if($result->num_rows>0) 
                {
                  $row = $result->fetch_array(MYSQLI_ASSOC);
                  $pass_hash = $row['password'];
                  if(password_verify($login_Password, $pass_hash)) 
                  {
                      $_SESSION["sname"] = 'admin';
                      header('Location: ./crud.php');
                  } else 
                  {
                    echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";
                  }
                }else {echo "<script type='text/javascript'>alert('Usuario o contraseña inválido');</script>";}
              }
        
    } 
  }}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

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
    <section>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="block">
              <div class="form-group">
                <!---->
                </div>
                <div class="form-signin w-100 m-auto">
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
    <!-- IMPORTS FOOTER END -->
    <!-- /Footer end-->
    <div id="scrollTop"><i class="fa fa-long-arrow-alt-up"></i></div>
    <!-- JavaScript files-->
</body>

</html>