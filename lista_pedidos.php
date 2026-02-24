<?php
session_start();
require_once("config.php");

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

// Obtener pedidos
$pedidos = $conn->query("
    SELECT p.id_pedido, p.total, p.estado, p.fecha,
           u.nombre AS usuario
    FROM pedidos p
    INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
    ORDER BY p.id_pedido DESC
");
?>

<h2>Lista de Pedidos</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Fecha</th>
    </tr>

    <?php while ($row = $pedidos->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_pedido']; ?></td>
            <td><?php echo $row['usuario']; ?></td>
            <td><?php echo $row['total']; ?></td>
            <td><?php echo $row['estado']; ?></td>
            <td><?php echo $row['fecha']; ?></td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="dashboard.php">Volver</a>