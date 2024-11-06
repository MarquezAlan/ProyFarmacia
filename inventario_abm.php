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

// Procesar el formulario de nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = limpiar_entrada($_POST['nombre']);
    $categoria = limpiar_entrada($_POST['categoria']);
    $descripcion = limpiar_entrada($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    // Insertar el nuevo producto en la base de datos
    $sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, cantidad) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssdi", $nombre, $categoria, $descripcion, $precio, $cantidad);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Producto agregado con éxito.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al agregar el producto.</div>";
    }
}

// Consulta a la base de datos para mostrar el inventario
$sql = "SELECT id, nombre, categoria, descripcion, precio, cantidad FROM productos";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacias Buena Salud - Inventario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmacias Buena Salud</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="pedidos_abm.php">Ver Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="inventario_abm.php">Ver Inventario</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Volver al Inicio</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="my-4">Inventario de Productos</h1>

        <!-- Formulario para añadir nuevo producto -->
        <div class="card mb-4">
            <div class="card-header">Agregar Nuevo Producto</div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad Disponible</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Producto</button>
                </form>
            </div>
        </div>

        <!-- Tabla para mostrar inventario -->
        <?php if ($resultado->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $fila["id"]; ?></td>
                                <td><?php echo $fila["nombre"]; ?></td>
                                <td><?php echo $fila["categoria"]; ?></td>
                                <td><?php echo $fila["descripcion"]; ?></td>
                                <td>$<?php echo $fila["precio"]; ?></td>
                                <td><?php echo $fila["cantidad"]; ?></td>
                                <td>
                                    <a href="editar_producto.php?id=<?php echo $fila["id"]; ?>" class="btn btn-info btn-sm">Editar</a>
                                    <a href="eliminar_producto.php?id=<?php echo $fila["id"]; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay productos en el inventario.</div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conexion->close();

// Función para limpiar la entrada de datos
function limpiar_entrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}
?>
