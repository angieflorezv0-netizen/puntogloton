<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

echo "<h2>Bienvenida " . $_SESSION['nombre'] . "</h2>";
echo "<p>Rol: " . $_SESSION['rol'] . "</p>";

echo "<hr>";

if ($_SESSION['rol'] == "Administrador") {
    echo "<a href='productos.php'>Gestionar Productos</a><br>";
    echo "<a href='usuarios.php'>Gestionar Usuarios</a><br>";
}

if ($_SESSION['rol'] == "Empleado" || $_SESSION['rol'] == "Cajero") {
    echo "<a href='pedidos.php'>Registrar Pedido</a><br>";
}

echo "<br><a href='logout.php'>Cerrar Sesión</a>";
?>