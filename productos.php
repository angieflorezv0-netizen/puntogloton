<?php
session_start();
require_once("config.php");

if (!isset($_SESSION['nombre']) || $_SESSION['rol'] != "Administrador") {
    header("Location: index.php");
    exit();
}

// INSERTAR PRODUCTO
if (isset($_POST['guardar'])) {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (nombre, precio, stock) 
            VALUES ('$nombre', '$precio', '$stock')";

    $conn->query($sql);
}
// ACTUALIZAR PRODUCTO
if (isset($_POST['actualizar'])) {

    $id = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $conn->query("UPDATE productos 
                  SET nombre='$nombre', 
                      precio='$precio', 
                      stock='$stock'
                  WHERE id_producto=$id");
}

// ELIMINAR PRODUCTO
if (isset($_GET['eliminar'])) {

    $id = $_GET['eliminar'];

    $conn->query("DELETE FROM productos WHERE id_producto = $id");
}
// CARGAR DATOS PARA EDITAR
$editar = false;

if (isset($_GET['editar'])) {

    $editar = true;
    $id = $_GET['editar'];

    $resultado = $conn->query("SELECT * FROM productos WHERE id_producto = $id");
    $producto = $resultado->fetch_assoc();
}
// OBTENER PRODUCTOS
$productos = $conn->query("SELECT * FROM productos");
?>

<h2>Gestión de Productos</h2>

<form method="POST">
    <input type="hidden" name="id_producto" 
        value="<?php echo $editar ? $producto['id_producto'] : ''; ?>">

    Nombre:
    <input type="text" name="nombre" required
        value="<?php echo $editar ? $producto['nombre'] : ''; ?>">

    Precio:
    <input type="number" name="precio" required
        value="<?php echo $editar ? $producto['precio'] : ''; ?>">

    Stock:
    <input type="number" name="stock" required
        value="<?php echo $editar ? $producto['stock'] : ''; ?>">

    <button type="submit" name="<?php echo $editar ? 'actualizar' : 'guardar'; ?>">
        <?php echo $editar ? 'Actualizar' : 'Guardar'; ?>
    </button>
</form>

<hr>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>

    <?php while ($row = $productos->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_producto']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['precio']; ?></td>
            <td><?php echo $row['stock']; ?></td>
            <td>
    <td>
    <a href="productos.php?editar=<?php echo $row['id_producto']; ?>">
        Editar
    </a> |
    <a href="productos.php?eliminar=<?php echo $row['id_producto']; ?>">
        Eliminar
    </a>
</td>
</td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="dashboard.php">Volver</a>