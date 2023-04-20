<!DOCTYPE html>
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
  <!-- Hero Section-->
  <section class="hero">
    <div class="container">
      <!-- Breadcrumbs -->
      <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        <li class="breadcrumb-item active">Contacto </li>
      </ol>
      <!-- Hero Content-->
      <div class="hero-content pb-5 text-center">
        <h1 class="hero-heading">Contacto</h1>
        <div class="row">
        </div>
      </div>
    </div>
  </section>
  <section class="py-6" style="background: #fafafa;">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center text-md-start">
          <svg class="svg-icon svg-icon-light text-primary w-3rem h-3rem mb-3">
            <use xlink:href="#navigation-map-1"> </use>
          </svg>
          <h4 class="ff-base">Dirección</h4>
          <a class="text-muted" href="https://www.google.es/maps/place/Famosso+Barber/@40.6620243,-3.7670055,19z/data=!4m5!3m4!1s0xd417df9abbc1963:0x871972d303df646c!8m2!3d40.6620269!4d-3.7666206?hl=es">Av. de la Libertad, 4, 28770 Colmenar Viejo, Madrid</a>
        </div>
        <div class="col-md-4 text-center text-md-start">
          <svg class="svg-icon svg-icon-light text-primary w-3rem h-3rem mb-3">
            <use xlink:href="#audio-call-1"> </use>
          </svg>
          <h4 class="ff-base">Teléfono</h4>
          <p class="text-muted">Llámanos y pide tu cita</p>
          <a class="text-muted" href="tel: +34665656566">+34 665 656 566</a>
        </div>
        <div class="col-md-4 text-center text-md-start">
          <svg class="svg-icon svg-icon-light text-primary w-3rem h-3rem mb-3">
            <use xlink:href="#mail-1"> </use>
          </svg>
          <h4 class="ff-base">Correo electrónico</h4>
          <p class="text-muted">Contáctanos para cualquier tipo de duda o problema que pueda surgirte</p>
          <ul class="list-unstyled text-muted">
            <li><a class="text-muted" href="mailto:famossobarber2@gmail.com" target="_blank">famossobarber2@gmail.com</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="py-6">
    <div class="container">
      <header class="mb-5">
        <h2 class="text-uppercase h5">Contacto</h2>
      </header>
      <div class="row">
        <div class="col-md-6 mb-5 mb-md-0">

          <form class="form" id="contact-form" method="post" action="contacto.php">
            <div class="controls">
              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-4">
                    <label class="form-label" for="name" pattern=[A-Z\sa-z]{3,20}>Nombre</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Nombre" required="required">
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="email">Correo electrónico *</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="info@gmail.com" required="required">
              </div>
              <div class="mb-4">
                <label class="form-label" for="message">Mensaje *</label>
                <textarea class="form-control" rows="4" name="message" id="message" placeholder="¿En qué podemos ayudarte?" required="required"></textarea>
                <small class="text-muted">Los campos con * son obligatorios.</small>
              </div>
              <button class="btn btn-outline-dark" type="submit">Contactar</button>
            </div>
          </form>
          <?php
          ini_set('sendmail_from', "famossobarber2@gmail.com"); // My usual e-mail address
          //ini_set( 'SMTP', $_POST['email'] );  // My usual sender
          ini_set('smtp_port', 25);

          if ($_POST) {
            $name = "";
            $email = "";
            $message = "";

            if (isset($_POST['name'])) {
              $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            }

            if (isset($_POST['email'])) {
              $email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
              $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            }

            if (isset($_POST['message'])) {
              $message = htmlspecialchars($_POST['message']);
            }

            $recipient = "famossobarber2@gmail.com";


            $headers  = 'MIME-Version: 1.0' . "\r\n"
              . 'Content-type: text/html; charset=utf-8' . "\r\n"
              . 'From: ' . $email . "\r\n";

            if (mail($recipient, $message, $headers)) {
              echo "<p>Gracias por contactar con nosotros, $name. Te responderemos lo antes posible.</p>";
            } else {
              echo '<p>Lo lamentamos, el correo no se pudo enviar correctamente.</p>';
            }
          } else {
            echo '<p>Algo ha salido mal.</p>';
          }

          ?>


        </div>
        <div class="col-md-6 col-md-full-right">
          <!-- Google map -->
          <div style="height: 100%;" class="position-md-absolute end-0 top-0 w-100 h-400 h-md-800">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d756.6355111417523!2d-3.7670055!3d40.6620243!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd417df9abbc1963%3A0x871972d303df646c!2sFamosso%20Barber!5e0!3m2!1ses!2ses!4v1649246028664!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>



    </div>
  </section>

  <!--<div id="map" style="height: 400px;"></div>-->
  <!-- IMPORTS FOOTER BEGIN -->
  <?php include "includes/importFooter.php"; ?>
  <!-- IMPORTS FOOTER END -->