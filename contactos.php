<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacias Buena Salud - Contactos</title>
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
            margin-bottom: 20px;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            margin-top: 30px;
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
        .form-contacto {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 40px;
        }
        .form-contacto h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .form-contacto label {
            font-weight: bold;
        }
        .form-contacto .form-control {
            margin-bottom: 20px;
        }
        .form-contacto .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            margin-top: 20px;
        }
        .form-contacto .btn-primary:hover {
            background-color: #1a242f;
            border-color: #1a242f;
        }
        .map-container {
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }
        .form-contacto, .map-container iframe {
            width: 100%;
            margin-bottom: 20px;
        }
        @media (min-width: 768px) {
            .form-contacto, .map-container iframe {
                width: 48%;
                margin-bottom: 0;
            }
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
                <li class="nav-item active"><a class="nav-link" href="contactos.php">Contactos</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Inicio de Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">¡Contáctanos!</h1>
            <p class="lead">Estamos aquí para ayudarte en todo lo que necesites.</p>
        </div>
    </div>

    <div class="container services">
        <div class="row">
            <div class="col-md-4">
                <div class="category-card text-center">
                    <i class="fas fa-phone icon"></i>
                    <h3>Soporte Telefónico</h3>
                    <p>Para consultas rápidas, llámanos al siguiente número:</p>
                    <p><strong>+591 63120110</strong></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card text-center">
                    <i class="fas fa-envelope icon"></i>
                    <h3>Correo Electrónico</h3>
                    <p>Envíanos un correo electrónico a:</p>
                    <p><strong>contacto@farmaciaintegral.com</strong></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card text-center">
                    <i class="fas fa-map-marker-alt icon"></i>
                    <h3>Visítanos</h3>
                    <p>Nuestra dirección:</p>
                    <p><strong>Calle Principal #123, Ciudad, País</strong></p>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 mb-5">
            <a class="btn btn-primary btn-lg" href="index.php" role="button">Volver a Inicio</a>
        </div>

        <div class="map-container">
            <div class="form-contacto">
                <h2>Envíanos un mensaje</h2>
                <form>
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre completo">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" placeholder="Ingresa tu correo electrónico">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono de Contacto</label>
                        <input type="tel" class="form-control" id="telefono" placeholder="Ingresa tu número de teléfono">
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea class="form-control" id="mensaje" rows="3" placeholder="Escribe tu mensaje"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </form>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3824.8478941650555!2d-68.19382612567279!3d-16.53377494159422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915edee27dbe1d5d%3A0xb44839aaed841ac2!2sFarmacia%20Buena%20Salud!5e0!3m2!1ses-419!2sbo!4v1718266888910!5m2!1ses-419!2sbo" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
