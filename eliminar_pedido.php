<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $pedido_id = limpiar_entrada($_GET['id']);

    // Eliminar el pedido de la base de datos
    if (eliminar_pedido($pedido_id)) {
        echo "<div class='alert alert-success' role='alert'>Pedido eliminado correctamente.</div>";
        echo '<meta http-equiv="refresh" content="2; URL=pedidos.php">';
    } else {
        echo "<div class='alert alert-danger' role='alert'>No se pudo eliminar el pedido.</div>";
    }
} else {
    echo "<div class='alert alert-warning' role='alert'>ID del pedido no proporcionado.</div>";
}

// Función para eliminar un pedido de la base de datos
function eliminar_pedido($pedido_id) {
    $conexion = new mysqli("localhost", "root", "hola123", "drones");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL para eliminar el pedido
    $sql = "DELETE FROM pedidos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    
    // Ejecutar la consulta
    $resultado = $stmt->execute();

    // Cerrar la conexión y devolver el resultado
    $stmt->close();
    $conexion->close();

    return $resultado;
}
?>
