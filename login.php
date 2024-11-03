<?php
session_start();
if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "marquez", "12345", "dron_ucb");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta a la base de datos para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND contraseña = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contraseña);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Las credenciales son correctas, iniciar sesión y redirigir
        $_SESSION['usuario'] = $usuario;
        header("Location: pedidos_abm.php");
        exit();
    } else {
        // Las credenciales son incorrectas, mostrar mensaje de error
        $mensaje_error = "Usuario o contraseña incorrectos";
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRON UCB - Iniciar sesión</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
        }
        .login-header {
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
            color: #2c3e50;
        }
        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .form-group label {
            font-weight: bold;
            color: #2c3e50;
        }
        .alert {
            text-align: center;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmacias Buena Salud</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="medicamentos.php">Medicamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="pedidos.php">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="contactos.php">Contactos</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Inicio de Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="login-container">
        <h1 class="login-header">Iniciar sesión</h1>

        <?php if (isset($mensaje_error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $mensaje_error; ?>
        </div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form action="login.php" method="POST" class="mb-3">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>

        <!-- Botón para ir a la página de inicio -->
        <a href="index.php" class="btn btn-secondary btn-block">Ir a la página de inicio</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
