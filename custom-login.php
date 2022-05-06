<?php
include 'conexion.php';
$errores = '';
$enviado = true;
// Comprobamos que el formulario haya sido enviado con las variables que hayamos puesto en index.view, deben llamarse igual!
if (isset($_POST['submit'])) {
  $Nombre = $_POST['nombre'];
  $Password = $_POST['password'];
  $Email = $_POST['email'];


  // Registro de usuario nuevo

  if (!empty($Nombre)) { //Comprobamos que nombre haya sido ingresasdo
    $Nombre = filter_var($Nombre, FILTER_SANITIZE_STRING); //limpia o verifica que es un texto
  } else {
    $errores .= 'Por ingresa un nombre <br />';
    $enviado = false;
  }

  if (!empty($Email)) { //comprobamos que es un email válido y que lo ha enviado
    $Email = filter_var($Email, FILTER_SANITIZE_EMAIL);
  } else {
    $errores = 'Por favor ingresa un correo <br/>'; // caso el correo no este puesto devuelve un error
    $enviado = false;
  }
 
  $conexion = new mysqli("localhost", "root", "", "peluqueria");
  if ($conexion->connect_errno) {
      die('Lo siento hubo un problema con el servidor');
  } else {
       // Comprobamos que el usuario existe
        $consulta = mysqli_query($conexion, "SELECT * FROM clientes WHERE Nombre = '$Nombre' or email ='$Email' "); // VERIFICAMOS QUE EL NOMBRE INTRODUCIDO NO ESTA REGISTRADO
        if (mysqli_num_rows($consulta)==0) { // CASO DE QUE LA CONSULTA ESTE VACIA ES QUE NO EXISTE UN USUARIO CON ESE NOMBRE Y PODEMOS SEGUIR CON EL REGISTRO
          $statement = $conexion->prepare("INSERT INTO clientes (id_cliente, nombre, password, email) VALUES (?,?,?,?)");
          $ID = null;
          $statement->bind_param('isss', $ID, $Nombre, $Password, $Email);
          $statement->execute();
          if ($statement->affected_rows >= 1) {  //si todo va bien carga la pagina principal
            sleep(5); //Damos unos segundos para redireccionar
            header("Location: ./calendario/calendario.php");
            exit;
          }
      } else {
        echo "<script type='text/javascript'>alert('El usuario o correo ya está registrado');</script>";
      }
    }
  }
// PARA LOGIN
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
      $consulta = mysqli_query($conexion, "SELECT * FROM clientes WHERE Nombre = '$login_Nombre' and password = '$login_Password'");
      if ($login_Nombre = mysqli_fetch_assoc($consulta)) {
        header("Location: ./calendario/calendario.php");
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
            <div class="col-lg-5">
              <div class="block">
                <div class="block-header">
                  <h6 class="text-uppercase mb-0">Registrate</h6>
                </div>
                <div class="block-body">
                  <p class="lead">¿No estas registrado todavia?</p>
                  <p class="text-muted"></p>
                  <p class="text-muted">Registrate para recibir nuestras ofertas en tu correo y pedir tu cita online. Si no desea registrase puede contactar con nosotros a través del siguiente enlace.
                    <br><a href="contacto.php">Contacto</a>
                  </p>
                  <hr>
                  <form action=" " name="formulario" method="post">
                    <!-- Usamos el método post para recoger lo que seleccione el usuario en unas variables -->
                    <div class="mb-4">
                      <label class="form-label" for="name">Nombre</label>
                      <input type="text" placeholder="Nombre:" name="nombre" id="nombre">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="email">Correo</label>
                      <input type="email" placeholder="Correo:" name="email" id="email">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="password">Contraseña</label>
                      <input type="password" placeholder="Contraseña:" name="password" id="password">
                    </div>
                    <div class="mb-4 text-center">
                      <input type="submit" name="submit" class="btn btn-primary" value="Send"> <!-- boton para enviar los datos -->
                      <input type="reset" name="reset" class="btn btn-secundary" value="Reset">
                    </div>
                  </form>
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
    <script>
      // ------------------------------------------------------- //
      //   Inject SVG Sprite - 
      //   see more here 
      //   https://css-tricks.com/ajaxing-svg-sprite/
      // ------------------------------------------------------ //
      function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function(e) {
          var div = document.createElement("div");
          div.className = 'd-none';
          div.innerHTML = ajax.responseText;
          document.body.insertBefore(div, document.body.childNodes[0]);
        }
      }
      // this is set to Bootstrapious website as you cannot 
      // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
      // while using file:// protocol
      // pls don't forget to change to your domain :)
      injectSvgSprite('https://demo.bootstrapious.com/sell/1-2-0/icons/orion-svg-sprite.svg');
    </script>
    <!-- jQuery-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap JavaScript Bundle (Popper.js included)-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Owl Carousel-->
    <script src="vendor/owl.carousel/owl.carousel.js"></script>
    <script src="vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
    <!-- NoUI Slider (price slider)-->
    <script src="vendor/nouislider/nouislider.min.js"></script>
    <!-- Smooth scrolling-->
    <script src="vendor/smooth-scroll/smooth-scroll.polyfills.min.js"></script>
    <!-- Lightbox gallery-->
    <script src="vendor/glightbox/js/glightbox.min.js"> </script>
    <!-- Object Fit Images - Fallback for browsers that don't support object-fit-->
    <script src="vendor/object-fit-images/ofi.min.js"></script>
    <script>
      var basePath = ''
    </script>
    <script src="js/theme.js"></script>
</body>

</html>