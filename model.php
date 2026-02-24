<?php
require_once("config.php");

class Usuario {

    public static function login($correo, $contraseña) {
        global $conn;

        $sql = "SELECT usuarios.*, roles.nombre_rol 
                FROM usuarios
                INNER JOIN roles ON usuarios.id_rol = roles.id_rol
                WHERE correo='$correo' AND contraseña='$contraseña'";

        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        } else {
            return false;
        }
    }
}
?>