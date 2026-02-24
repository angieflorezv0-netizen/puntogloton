<?php
session_start();
require_once("model.php");

if (isset($_POST['login'])) {

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $usuario = Usuario::login($correo, $contraseña);

    if ($usuario) {

        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['nombre_rol'];

        header("Location: dashboard.php");
        exit();

    } else {
        echo "Correo o contraseña incorrectos";
    }
}
?>