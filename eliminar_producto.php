<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "marquez", "12345", "farmacia_ucb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Eliminar el producto de la base de datos
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: inventario_abm.php");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al eliminar el producto.</div>";
    }

    $stmt->close();
}

$conexion->close();
?>
