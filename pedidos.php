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

// Función para limpiar la entrada de datos
function limpiar_entrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = limpiar_entrada($_POST['nombre']);
    $correo = limpiar_entrada($_POST['correo']);
    $telefono = limpiar_entrada($_POST['telefono']);
    $productos = $_POST['productos'];
    $mensaje = limpiar_entrada($_POST['mensaje']);
    $usuario = $_SESSION['usuario'];
    
    $total = 0;
    $costo_envio = 5.00;  // Ejemplo de costo de envío fijo
    $numero_pedido = uniqid();  // Generar un número de pedido único
    $fecha_entrega = date('Y-m-d', strtotime('+3 days'));  // Ejemplo de fecha de entrega
    
    // Insertar cada producto del pedido en la base de datos
    foreach ($productos as $producto) {
        $producto_id = $producto['id'];
        $cantidad = $producto['cantidad'];
        if ($cantidad > 0) {
            // Obtener el precio del producto
            $sql = "SELECT precio FROM productos WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $producto_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $producto = $resultado->fetch_assoc();
            $precio = $producto['precio'];
            
            $subtotal = $precio * $cantidad;
            $total += $subtotal;

            $sql = "INSERT INTO pedidos (numero_pedido, id_producto, precio, costo_envio, total, fecha_entrega, usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sidddss", $numero_pedido, $producto_id, $precio, $costo_envio, $subtotal, $fecha_entrega, $usuario);
            $stmt->execute();
        }
    }

    $total += $costo_envio;

    if ($total > $costo_envio) {
        echo "<div class='alert alert-success' role='alert'>Pedido realizado con éxito. Total: $" . number_format($total, 2) . "</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al realizar el pedido.</div>";
    }

    $stmt->close();
}

// Obtener los productos de la base de datos
$sql = "SELECT id, nombre, precio FROM productos";
$resultado = $conexion->query($sql);
$productos = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacias Buena Salud - Pedidos</title>
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
            background-color: #fff;
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
            margin-bottom: 20px; /* Ajuste para reducir espacio entre el texto y el borde */
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            margin-top: 30px; /* Ajuste para mover el botón hacia abajo */
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
            padding: 30px 0; /* Ajuste para reducir espacio en la sección de servicios */
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
        .form-pedidos {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 40px;
        }
        .form-pedidos h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .form-pedidos label {
            font-weight: bold;
        }
        .form-pedidos .form-control {
            margin-bottom: 20px;
        }
        .form-pedidos .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            margin-top: 20px;
        }
        .form-pedidos .btn-primary:hover {
            background-color: #1a242f;
            border-color: #1a242f;
        }
        .total-container {
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addProductBtn = document.querySelector('.add-product-btn');
            const calculateTotalBtn = document.querySelector('.calculate-total-btn');
            const productsContainer = document.querySelector('.products-container');
            const totalContainer = document.querySelector('.total-container');
            const productSelectTemplate = document.querySelector('#product-select-template').innerHTML;
            let productCount = 0;

            function calculateTotal() {
                let total = 0;
                const productSelects = document.querySelectorAll('.product-select');
                productSelects.forEach(select => {
                    const cantidad = parseInt(select.querySelector('.cantidad').value);
                    const precio = parseFloat(select.querySelector('.nombre-producto').selectedOptions[0].dataset.precio);
                    if (cantidad > 0) {
                        total += cantidad * precio;
                    }
                });
                totalContainer.innerHTML = `Total: $${total.toFixed(2)}`;
            }

            addProductBtn.addEventListener('click', function() {
                productCount++;
                const newProductSelect = document.createElement('div');
                newProductSelect.innerHTML = productSelectTemplate.replace(/__INDEX__/g, productCount);
                productsContainer.appendChild(newProductSelect);

                newProductSelect.querySelector('.nombre-producto').addEventListener('change', function() {
                    const precio = parseFloat(this.selectedOptions[0].dataset.precio);
                    newProductSelect.querySelector('.cantidad').dataset.precio = precio;
                });
                newProductSelect.querySelector('.remove-product-btn').addEventListener('click', function() {
                    newProductSelect.remove();
                });
            });

            calculateTotalBtn.addEventListener('click', calculateTotal);
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmacias Buena Salud</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="medicamentos.php">Medicamentos</a></li>
                <li class="nav-item active"><a class="nav-link" href="pedidos.php">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="contactos.php">Contactos</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Inicio de Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">Realiza tu pedido fácilmente</h1>
            <p class="lead">Encuentra lo que necesitas y realiza tus pedidos con nuestra plataforma.</p>
        </div>
    </div>

    <div class="container services">
        <div class="row">
            <div class="col-md-4">
                <div class="category-card text-center">
                    <i class="fas fa-shopping-cart icon"></i>
                    <h3>Pedidos Online</h3>
                    <p>Realiza tus pedidos de medicamentos desde la comodidad de tu hogar. Entrega rápida y segura garantizada.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card text-center">
                    <i class="fas fa-truck icon"></i>
                    <h3>Entrega Rápida</h3>
                    <p>Recibe tus medicamentos en menos de 24 horas. Servicio de entrega eficiente a tu puerta.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card text-center">
                    <i class="fas fa-credit-card icon"></i>
                    <h3>Pagos Seguros</h3>
                    <p>Pagos seguros y protegidos para tu tranquilidad. Variedad de métodos disponibles.</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 mb-5">
            <a class="btn btn-primary btn-lg" href="medicamentos.php" role="button">Ver Catálogo de Medicamentos</a>
        </div>

        <div class="form-pedidos">
            <h2>Realiza tu pedido</h2>
            <form method="POST" action="pedidos.php">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingresa tu correo electrónico" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono de Contacto</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingresa tu número de teléfono" required>
                </div>
                <div class="form-group">
                    <label>Productos</label>
                    <div class="products-container"></div>
                    <button type="button" class="btn btn-info add-product-btn">Agregar Producto</button>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje o Detalle de Pedido</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="3" placeholder="Escribe los detalles de tu pedido"></textarea>
                </div>
                <div class="total-container">Total: $0.00</div>
                <button type="button" class="btn btn-secondary calculate-total-btn">Calcular Total</button>
                <button type="submit" class="btn btn-primary">Enviar Pedido</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>Horario de atención: Lunes a Viernes de 9:00 AM a 6:00 PM</p>
            <p>Teléfono: +591 63120110 | Correo electrónico: contacto@farmaciaintegral.com</p>
        </div>
    </footer>

    <script type="text/template" id="product-select-template">
        <div class="product-select row mb-3">
            <div class="col-md-6">
                <select class="form-control nombre-producto" name="productos[__INDEX__][id]" required>
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo $producto['id']; ?>" data-precio="<?php echo $producto['precio']; ?>">
                            <?php echo $producto['nombre']; ?> ($<?php echo number_format($producto['precio'], 2); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control cantidad" name="productos[__INDEX__][cantidad]" min="1" value="1" data-precio="0" required>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-product-btn">Eliminar</button>
            </div>
        </div>
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addProductBtn = document.querySelector('.add-product-btn');
            const calculateTotalBtn = document.querySelector('.calculate-total-btn');
            const productsContainer = document.querySelector('.products-container');
            const totalContainer = document.querySelector('.total-container');
            const productSelectTemplate = document.querySelector('#product-select-template').innerHTML;
            let productCount = 0;

            function calculateTotal() {
                let total = 0;
                const productSelects = document.querySelectorAll('.product-select');
                productSelects.forEach(select => {
                    const cantidad = parseInt(select.querySelector('.cantidad').value);
                    const precio = parseFloat(select.querySelector('.nombre-producto').selectedOptions[0].dataset.precio);
                    if (cantidad > 0) {
                        total += cantidad * precio;
                    }
                });
                totalContainer.innerHTML = `Total: $${total.toFixed(2)}`;
            }

            addProductBtn.addEventListener('click', function() {
                productCount++;
                const newProductSelect = document.createElement('div');
                newProductSelect.innerHTML = productSelectTemplate.replace(/__INDEX__/g, productCount);
                productsContainer.appendChild(newProductSelect);

                newProductSelect.querySelector('.nombre-producto').addEventListener('change', function() {
                    const precio = parseFloat(this.selectedOptions[0].dataset.precio);
                    newProductSelect.querySelector('.cantidad').dataset.precio = precio;
                });
                newProductSelect.querySelector('.remove-product-btn').addEventListener('click', function() {
                    newProductSelect.remove();
                });
            });

            calculateTotalBtn.addEventListener('click', calculateTotal);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
