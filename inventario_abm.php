<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacias Buena Salud - Inventario</title>
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
            padding: 10px 0;
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
        .table-responsive {
            margin-top: 20px;
        }
        .btn-info {
            margin-right: 5px;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 10px 0; /* Ajuste para hacer más pequeño el pie de página */
            text-align: center;
            margin-top: 20px; /* Ajuste para reducir el margen superior */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
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
        <?php
        // Conexión a la base de datos
        $conexion = new mysqli("localhost", "marquez", "12345", "farmacia_ucb");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta a la base de datos
        $sql = "SELECT id, nombre, categoria, descripcion, precio FROM productos";
        $resultado = $conexion->query($sql);

        // Comprobar si hay resultados
        if ($resultado->num_rows > 0) {
            // Imprimir los resultados en una tabla
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>ID</th><th>Nombre</th><th>Categoría</th><th>Descripción</th><th>Precio</th><th>Acciones</th></tr></thead>";
            echo "<tbody>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila["id"] . "</td>";
                echo "<td>" . $fila["nombre"] . "</td>";
                echo "<td>" . $fila["categoria"] . "</td>";
                echo "<td>" . $fila["descripcion"] . "</td>";
                echo "<td>$" . $fila["precio"] . "</td>";
                echo "<td>";
                echo "<a href='editar_producto.php?id=" . $fila["id"] . "' class='btn btn-info btn-sm'>Editar</a> ";
                echo "<a href='eliminar_producto.php?id=" . $fila["id"] . "' class='btn btn-danger btn-sm'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-info' role='alert'>No se encontraron productos en el inventario.</div>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
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
