<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "marquez", "12345", "farmacia_ucb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los productos de la base de datos
$sql = "SELECT id, nombre, descripcion, precio FROM productos";
$resultado = $conexion->query($sql);
$productos = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}

$conexion->close();

// Lista de colores
$colores = ["#f8d7da", "#d1ecf1", "#d4edda", "#fff3cd", "#cce5ff", "#e2e3e5"];
$color_index = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos - Farmacias Buena Salud</title>
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
        .jumbotron {
            background: url('imagenes/fondo.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 25px;
            text-shadow: 2px 2px 4px #000000;
        }
        .jumbotron h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .jumbotron p {
            font-size: 1.2em;
        }
        .category-card {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .category-card img {
            width: 100%;
            border-radius: 8px;
        }
        .category-card h3 {
            margin-top: 15px;
        }
        .category-card p {
            flex-grow: 1;
            margin-bottom: 20px;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            margin-top: 20px;
            display: block;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-primary:hover {
            background-color: #1a242f;
            border-color: #1a242f;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }
        .text-center {
            margin: 40px 0;
            text-align: center;
        }
        .icon {
            font-size: 4em;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .services {
            padding: 30px 0;
        }
        .testimonial {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .testimonial p {
            font-style: italic;
        }
        .testimonial h5 {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmacias Buena Salud</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item active"><a class="nav-link" href="medicamentos.php">Medicamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="pedidos.php">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="contactos.php">Contactos</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Inicio de Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">Nuestros Medicamentos</h1>
            <p class="lead">Descubre nuestra amplia variedad de productos farmacéuticos.</p>
        </div>
    </div>

    <div class="container services">
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4">
                    <div class="category-card text-center" style="background-color: <?php echo $colores[$color_index]; ?>;">
                        <h3><?php echo $producto['nombre']; ?></h3>
                        <p><?php echo $producto['descripcion']; ?></p>
                        <p><strong>Precio: $<?php echo number_format($producto['precio'], 2); ?></strong></p>
                        <a class="btn btn-primary" href="pedidos.php?producto_id=<?php echo $producto['id']; ?>">Comprar</a>
                    </div>
                </div>
                <?php 
                    $color_index = ($color_index + 1) % count($colores); 
                ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container testimonials">
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial">
                    <p>"Farmacias Buena Salud ha sido un salvavidas. La entrega rápida y el excelente servicio al cliente me han impresionado."</p>
                    <h5>- Juan Pérez</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial">
                    <p>"La atención 24/7 es increíble. Pude resolver una emergencia en la madrugada gracias a ellos."</p>
                    <h5>- María Gómez</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial">
                    <p>"El asesoramiento profesional que ofrecen es invaluable. Siempre encuentro lo que necesito y entiendo cómo usarlo correctamente."</p>
                    <h5>- Carlos Martínez</h5>
                </div>
            </div>
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
