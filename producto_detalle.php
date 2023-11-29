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

    <link rel="stylesheet" href="css/producto_detalle.css">

    <script>
        function agregarAlCarrito(producto_id, precio, stock) {
            // Obtener la cantidad seleccionada por el usuario desde el menú desplegable
            var cantidadSelect = document.getElementById('cantidad');
            var cantidad = cantidadSelect.options[cantidadSelect.selectedIndex].value;

            // Aquí puedes realizar otras acciones, como enviar la información al servidor o mostrar un mensaje al usuario
            alert('Producto agregado al carrito: ' + cantidad + ' unidades');
        }
    </script>

</head>

<body>

    <header>

        <div class="fila">
            <div class="item-menu"><a href="index.php"><img src="img/InfinitiTech_Universe_logo_shopping.jpg"
                        alt="InfinitiTech Universe Logo" class="logo"></a></div>
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

    <h1>Detalle del producto</h1>

    <div class="container">
        <div class="empleadoDetalle">
            <?php
                require "admin/funciones/conecta.php";

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $con = conecta();

                    $query = "SELECT nombre, codigo, descripcion, costo, stock, archivo FROM productos WHERE id = ? AND status = 1 AND eliminado = 0";

                    if ($stmt = $con->prepare($query)) {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($nombre, $codigo, $descripcion, $costo, $stock, $archivo);
                        if ($stmt->fetch()) {
                            
                            echo "<div class='imagenProducto'>";
                            if (!empty($archivo)) {
                                $photoPath = "admin/productos/archivos/" . $archivo;
                                echo "<img src='$photoPath' alt='Foto del Producto'>";
                            } else {
                                echo "<p>No hay foto disponible.</p>";
                            }
                            echo "</div>";

                            echo "<div class='infoProducto'>";
                            echo "<p class='nombreProducto'>$nombre</p>";
                            echo "<hr>";
                            echo "<p class='codigo'>Código: $codigo</p>";
                            echo "<hr>";
                            echo "<p class='descripcion'> $descripcion</p>";
                            echo "<hr>";
                            echo "<p>Costo: $$costo</p>";

                            if (isset($_SESSION['nombreUser']) && !empty($_SESSION['nombreUser'])) {
                                echo "<p>Stock disponible: $stock</p>";
                                // Menú desplegable con opciones de cantidad
                                echo "<label for='cantidad'>Cantidad:</label>";
                                echo "<select name='cantidad' id='cantidad'>";
                                
                                // Generar opciones basadas en el stock disponible
                                for ($i = 1; $i <= $stock; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                echo "</select>";
                                echo "<button onclick='agregarAlCarrito($costo, $stock)'>Añadir al carrito</button>";
                            }
                            echo "</div>";
                        } else {
                            echo "Producto no encontrado o no está activo.";
                        }

                        $stmt->close();
                    } else {
                        echo "Error en la consulta.";
                    }
                } else {
                    echo "ID de producto no proporcionado.";
                }
            ?>

        </div>
    </div>

    <hr>
    <hr>
    <hr>

    <div class="contenedorProductos">
  <?php

    // Realizar la consulta a la base de datos para obtener productos
    $query = $con->query("SELECT * FROM productos WHERE eliminado = 0 ORDER BY RAND() LIMIT 4");

    while ($producto = $query->fetch_assoc()) {
      $nombreProducto = $producto['nombre'];
      $precio = $producto['costo'];
      $imagen = $producto['archivo'];
      $stock = $producto['stock'];
  
      echo "<div class='producto'>";
      echo "<a href='producto_detalle.php?id={$producto['id']}'>"; // Enlace al detalle del producto
      echo "<img src='admin/productos/archivos/$imagen' alt='$nombreProducto'>";
      echo "<h3>$nombreProducto</h3>";
      echo "</a>";
      echo "<p>Precio: $precio</p>";
  
      // Verificar si hay una sesión iniciada
      if (isset($_SESSION['nombreUser']) && !empty($_SESSION['nombreUser'])) {
          echo "<p>Stock disponible: $stock</p>";
          // Menú desplegable con opciones de cantidad
          echo "<label for='cantidad'>Cantidad:</label>";
          echo "<select name='cantidad' id='cantidad'>";
          
          // Generar opciones basadas en el stock disponible
          for ($i = 1; $i <= $stock; $i++) {
              echo "<option value='$i'>$i</option>";
          }
          echo "</select>";
          echo "<button onclick='agregarAlCarrito($precio, $stock)'>Añadir al carrito</button>";
      }
  
      echo "</div>";
  }

      // Cerrar la conexión
      $con->close();
      ?>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
        <p>Contacto: info@misitioweb.com</p>
    </footer>

</body>

</html>