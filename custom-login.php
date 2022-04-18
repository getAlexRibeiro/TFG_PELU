<?php
include 'conexion.php';
$errores = '';
$enviado = true;
// Comprobamos que el formulario haya sido enviado con las variables que hayamos puesto en index.view, deben llamarse igual!
if (isset($_POST['submit'])) {
	$Nombre = $_POST['nombre'];
	$Password= $_POST['password'];
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
	
	if ($enviado == false) { //lanzamos los errores que hayan podido ocurrir
		echo $errores;

	} else { // SI TODOS LOS DATOS INTRODUCIDOS SON COMPATIBLES CON LOS SOLICITADOS 
			
		// Comprobamos que el usuario existe
		$conexion = new mysqli("localhost", "root", "", "peluqueria");

		if ($conexion->connect_errno) {
			die('Lo siento hubo un problema con el servidor');

		} else 

		if ($conexion->connect_errno) {
			die('Lo siento hubo un problema con el servidor'); // CASO ALGUN ERROR DE CONEXION


		} else {	

			$consulta = mysqli_query($conexion, "SELECT * FROM clientes WHERE nombre = $Nombre"); // VERIFICAMOS QUE EL NOMBRE INTRODUCIDO NO ESTA REGISTRADO
			
			if (!$consulta) { // CASO DE QUE LA CONSULTA ESTE VACIA ES QUE NO EXISTE UN USUARIO CON ESE NOMBRE Y PODEMOS SEGUIR CON EL REGISTRO
				
			
			$statement = $conexion->prepare("INSERT INTO clientes (id_cliente, nombre, email, password) VALUES (?,?,?,?)");



			$ID = null;
			$statement->bind_param('isss', $ID, $Nombre, $Email, $Password);


			$statement->execute();

			if ($statement->affected_rows >= 1) {  //si todo va bien carga la pagina principal
        echo "<script type='text/javascript'>alert('Bienvenido');</script>";
        sleep(5); //Damos unos segundos para redireccionar
        header("Location: ./calendario/calendario.php");
				exit;
			} else { //sino sale
				echo "<script type='text/javascript'>alert('El usuario ya existe');</script>";
        exit;
        sleep(3);
        echo"<script>location.reload();</script>";
			}
		}
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
      <!-- Top Bar-->
      <div class="top-bar">
        <div class="container-fluid">
          <div class="row d-flex align-items-center">
            <div class="col-sm-7 d-none d-sm-block">
              <ul class="list-inline topbar-text mb-0">
                <!--<li class="list-inline-item px-3 border-start d-none d-lg-inline-block">Free shipping on orders over $300</li>-->
              </ul>
            </div>
            <!--<div class="col-sm-5 d-flex justify-content-end">-->
              <!-- Language Dropdown-->
              <!--<div class="dropdown border-end px-3"><a class="dropdown-toggle topbar-link" id="langsDropdown" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="false"><img class="topbar-flag" src="assets/img/flag/gb.svg" alt="english">English</a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="langsDropdown"><a class="dropdown-item text-sm" href="#"><img class="topbar-flag" src="assets/img/flag/de.svg" alt="german">German</a><a class="dropdown-item text-sm" href="#"> <img class="topbar-flag" src="assets/img/flag/fr.svg" alt="french">French</a></div>
              </div>-->
              <!-- Currency Dropdown-->
              <!--<div class="dropdown ps-3 ms-0"><a class="dropdown-toggle topbar-link" id="currencyDropdown" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-dollar-sign text-xs align-middle mt-n1 me-2"> </i>USD</a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="currencyDropdown"><a class="dropdown-item text-sm" href="#"> <i class="fas fa-euro-sign text-xs align-middle mt-n1 me-2"> </i>EUR</a><a class="dropdown-item text-sm" href="#"><i class="fas fa-pound-sign text-xs align-middle mt-n1 me-2"> </i>GBP</a></div>
              </div>
            </div>-->
          </div>
        </div>
      </div>
      <!-- Top Bar End-->
       <!-- IMPORTS HEADER BEGIN -->
<?php include "includes/importMenu.php"; ?>
  <!-- IMPORTS HEADER END -->

 <!-- Hero Section-->
 <section class="hero">
      <div class="container">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb justify-content-center">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
              <div class="block-header">
                <h6 class="text-uppercase mb-0">Login</h6>
              </div>
              <div class="block-body">
                <p class="lead">Ya registrado?</p>
                <p class="text-muted"></p>
                <hr>
                <form action=" " name="formulario" method="post">
                  <div class="mb-4">
                    <label class="form-label" for="email1">Nombre Usuario</label>
                    <input type="text" placeholder="Nombre de usuario:" name="login_Nombre" id="login_Nombre">
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="password1">Password</label>
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
                <p class="lead">No estas registrado todavia?</p>
                <p class="text-muted"></p>
                <p class="text-muted">Registrate para recibir nuestras ofertas en tu correo y pedir tu cita online. Si no desea registrase puede contactar con nosotros a través del siguiente enlace.
                  <br><a href="contacto.php">Contacto</a></p>
                <hr>
                <form action=" " name="formulario" method="post"> <!-- Usamos el método post para recoger lo que seleccione el usuario en unas variables -->
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
    <script>var basePath = ''</script>
    <script src="js/theme.js"></script>
  </body>
</html>