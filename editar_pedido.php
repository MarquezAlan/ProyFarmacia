<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Obtener el ID del pedido desde la URL y limpiarlo
    $pedido_id = limpiar_entrada($_GET['id']);
    
    // Obtener los datos del pedido desde la base de datos
    $pedido = obtener_pedido_por_id($pedido_id);

    if ($pedido) {
        // Mostrar el formulario de edición con los datos del pedido
        mostrar_formulario_edicion($pedido);
    } else {
        echo "Pedido no encontrado.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Procesar el formulario enviado por POST
    $pedido_id = limpiar_entrada($_POST['id']);
    $nuevo_precio = limpiar_entrada($_POST['precio']);
    $nuevo_costo_envio = limpiar_entrada($_POST['costo_envio']);
    $nuevo_total = $nuevo_precio + $nuevo_costo_envio;

    // Actualizar el pedido en la base de datos
    if (actualizar_pedido($pedido_id, $nuevo_precio, $nuevo_costo_envio, $nuevo_total)) {
        // Muestra el mensaje de éxito y redirige a la lista de pedidos
        echo '<div class="alert alert-success" role="alert">Pedido actualizado correctamente.</div>';
        echo '<meta http-equiv="refresh" content="2; URL=pedidos.php">';
    } else {
        echo "No se pudo actualizar el pedido.";
    }
}

// Función para mostrar el formulario de edición
function mostrar_formulario_edicion($pedido) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Pedido - DRON UCB</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="my-4">Editar Pedido</h1>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $pedido['precio']; ?>">
                </div>
                <div class="form-group">
                    <label for="costo_envio">Costo de Envío:</label>
                    <input type="text" class="form-control" id="costo_envio" name="costo_envio" value="<?php echo $pedido['costo_envio']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
            <br>
            <a href="pedidos.php" class="btn btn-secondary">Cancelar y volver a la lista de pedidos</a>
        </div>
    </body>
    </html>
    <?php
}
?>
