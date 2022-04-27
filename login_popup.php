<?php
include 'conexion.php';
$errores = '';
$enviado = true;
// Comprobamos que el formulario haya sido enviado con las variables que hayamos puesto en index.view, deben llamarse igual!





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