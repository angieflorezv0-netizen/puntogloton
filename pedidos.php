<?php
session_start();
require_once("config.php");

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

// Obtener productos para el select
$productos = $conn->query("SELECT * FROM productos");

// Insertar pedido
if (isset($_POST['registrar'])) {

    $id_usuario = $_SESSION['nombre']; // luego lo mejoramos
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Obtener precio del producto
    $resultado = $conn->query("SELECT * FROM productos WHERE id_producto = $id_producto");
    $producto = $resultado->fetch_assoc();

    $precio = $producto['precio'];
    $subtotal = $precio * $cantidad;

    // Insertar en pedidos
    $conn->query("INSERT INTO pedidos (id_usuario, id_mesa, total, estado) 
                  VALUES (1, 1, $subtotal, 'pendiente')");

    $id_pedido = $conn->insert_id;

    // Insertar detalle
    $conn->query("INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario, subtotal)
                  VALUES ($id_pedido, $id_producto, $cantidad, $precio, $subtotal)");
                  // DESCONTAR STOCK
$conn->query("UPDATE productos 
              SET stock = stock - $cantidad
              WHERE id_producto = $id_producto");

    echo "Pedido registrado correctamente";
}
?>

<h2>Registrar Pedido</h2>

<form method="POST">
    Producto:
    <select name="id_producto" required>
        <option value="">Seleccione</option>
        <?php while ($row = $productos->fetch_assoc()) { ?>
            <option value="<?php echo $row['id_producto']; ?>">
                <?php echo $row['nombre']; ?>
            </option>
        <?php } ?>
    </select>

    Cantidad:
    <input type="number" name="cantidad" required>

    <button type="submit" name="registrar">Registrar</button>
</form>

<br>
<a href="dashboard.php">Volver</a>