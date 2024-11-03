<?php

// Función para limpiar la entrada de datos
function limpiar_entrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Función para obtener todos los pedidos de la base de datos
function obtener_pedidos($usuario) {
    $conexion = new mysqli("localhost", "root", "hola123", "farmacia_ucb");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $usuario = limpiar_entrada($usuario);

    // Consulta a la base de datos
    $sql = "SELECT pedidos.id, pedidos.numero_pedido, productos.nombre AS nombre_producto, pedidos.precio, pedidos.costo_envio, pedidos.total, pedidos.fecha_entrega
            FROM pedidos
            JOIN productos ON pedidos.id_producto = productos.id
            WHERE pedidos.usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    return $resultado;
}

// Función para obtener un pedido por su ID
function obtener_pedido_por_id($pedido_id) {
    $conexion = new mysqli("localhost", "marquez", "12345", "farmacia_ucb");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $pedido_id = limpiar_entrada($pedido_id);

    // Consulta a la base de datos
    $sql = "SELECT * FROM pedidos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    return $resultado->fetch_assoc();
}

// Función para actualizar un pedido en la base de datos
function actualizar_pedido($pedido_id, $nuevo_precio, $nuevo_costo_envio, $nuevo_total) {
    $conexion = new mysqli("localhost", "marquez", "12345", "farmacia_ucb");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $pedido_id = limpiar_entrada($pedido_id);
    $nuevo_precio = limpiar_entrada($nuevo_precio);
    $nuevo_costo_envio = limpiar_entrada($nuevo_costo_envio);
    $nuevo_total = limpiar_entrada($nuevo_total);

    // Actualizar el pedido en la base de datos
    $sql = "UPDATE pedidos SET precio = ?, costo_envio = ?, total = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("dddi", $nuevo_precio, $nuevo_costo_envio, $nuevo_total, $pedido_id);
    $resultado = $stmt->execute();

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    return $resultado;
}

// Función para eliminar un pedido de la base de datos
function eliminar_pedido($pedido_id) {
    $conexion = new mysqli("localhost", "root", "hola123", "farmacia_ucb");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $pedido_id = limpiar_entrada($pedido_id);

    // Eliminar el pedido de la base de datos
    $sql = "DELETE FROM pedidos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $resultado = $stmt->execute();

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    return $resultado;
}

?>
