<?php
    session_start();
    $nombre = isset($_SESSION['nombreUser']) ? $_SESSION['nombreUser'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinitiTech Universe</title>

    <link rel="icon" type="image/jpg" href="img/InfinitiTech_Universe_logo_shopping.jpg">

    <link rel="stylesheet" href="css/contacto_formulario.css">
</head>
<body>

<header>

    <div class="fila">
            <div class="item-menu"><a href="index.php""><img src="img/InfinitiTech_Universe_logo_shopping.jpg" alt="InfinitiTech Universe Logo" class="logo"></a></div>
            <div class="item-menu"><a href="index.php">Home</a></div>
            <div class="item-menu"><a href="producto.php">Productos</a></div>
            <div class="item-menu"><a href="#">Contacto</a></div>
            <?php if ($nombre) : ?>

                <div class="item-menu"><a href="#">Carrito</a></div>
                <div class="item-menu"><a href="funciones/cerrarSesion.php">Cerrar sesión</a></div> 

            <?php else : ?>

                <div class="item-menu"><a href="usuarioAlta.php">Registrarse</a></div>
                <div class="item-menu"><a href="inicioSesion.php">Iniciar Sesión</a></div>

            <?php endif; ?>        
    </div>

    </header>

    <h1>Contacto</h1>
    
    <div class="contenedor">
    <?php
    // Comprueba el parámetro de éxito en la URL
    if (isset($_GET['exito'])) {
        if ($_GET['exito'] == 'true') {
            echo "<script>alert('Correo enviado correctamente');</script>";
        } elseif ($_GET['exito'] == 'false' && isset($_GET['error'])) {
            $error = urldecode($_GET['error']);
            echo "<script>alert('Error al enviar el correo: $error');</script>";
        }
    }
    ?>
    <form action="contacto_envia.php" method="post">
        <label for="destinatario">Destinatario:</label>
        <input type="email" name="destinatario" required><br>

        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" required><br>

        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" rows="4" required></textarea><br>

        <input type="submit" value="Enviar Correo">
    </form>
</div>

    <footer>
      <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
      <p>Contacto: info@misitioweb.com</p>
    </footer>

</body>
</html>