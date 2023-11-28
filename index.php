<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InfinitiTech Universe</title>

  <link rel="icon" type="image/jpg" href="img/InfinitiTech_Universe_logo_shopping.jpg">
  <!-- Otros elementos del head, como scripts, meta tags, etc. -->
</head>
<body>
  <?php
  // Código PHP para generación de contenido dinámico
  $nombreUsuario = "Juan";
  ?>
  
  <header>
    <h1>Bienvenido, <?php echo $nombreUsuario; ?> </h1>
    <nav>
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Acerca de</a></li>
        <li><a href="#">Contacto</a></li>
      </ul>
    </nav>
  </header>

  <!-- Resto del contenido de la página -->

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
    <p>Contacto: info@misitioweb.com</p>
  </footer>
</body>
</html>
