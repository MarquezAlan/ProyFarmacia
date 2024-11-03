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

// Obtener los datos del producto a editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();
}

// Actualizar el producto en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = limpiar_entrada($_POST['nombre']);
    $categoria = limpiar_entrada($_POST['categoria']);
    $descripcion = limpiar_entrada($_POST['descripcion']);
    $precio = floatval($_POST['precio']);

    $sql = "UPDATE productos SET nombre = ?, categoria = ?, descripcion = ?, precio = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssdi", $nombre, $categoria, $descripcion, $precio, $id);

    if ($stmt->execute()) {
        header("Location: inventario_abm.php");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al actualizar el producto.</div>";
    }
}

// Función para limpiar la entrada de datos
function limpiar_entrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #2c3e50;
        }
        .navbar a {
            color: #fff;
        }
        .navbar-brand {
            font-size: 1.8em;
        }
        .container {
            margin-top: 30px;
        }
        .form-editar {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 40px;
        }
        .form-editar h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .form-editar label {
            font-weight: bold;
        }
        .form-editar .form-control {
            margin-bottom: 20px;
        }
        .form-editar .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            margin-top: 20px;
        }
        .form-editar .btn-primary:hover {
            background-color: #1a242f;
            border-color: #1a242f;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmacias Buena Salud</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="inventario_abm.php">Ver Inventario</a></li>
                <li class="nav-item"><a class="nav-link" href="pedidos_abm.php">Ver Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Volver al Inicio</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-editar">
            <h2>Editar Producto</h2>
            <form method="POST" action="editar_producto.php">
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $producto['categoria']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $producto['descripcion']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>Horario de atención: Lunes a Viernes de 9:00 AM a 6:00 PM</p>
            <p>Teléfono: +591 63120110 | Correo electrónico: contacto@farmaciaintegral.com</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
