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

    <link rel="stylesheet" href="css/index.css">

    <script>
  let promocionActual = 0;
  const totalPromociones = 3; // Total de promociones obtenidas de la base de datos
  let temporizador;

  document.addEventListener('DOMContentLoaded', function () {
    // Mostrar la primera imagen y actualizar los indicadores al cargar la página
    actualizarPromocion();
    actualizarIndicadores();

    // Iniciar el temporizador automático (cambio cada 5 segundos, puedes ajustarlo)
    temporizador = setInterval(function () {
      cambiarPromocion(1);
    }, 5000);
  });

  function cambiarPromocion(cambio) {
    clearInterval(temporizador); // Limpiar el temporizador automático

    promocionActual += cambio;

    if (promocionActual < 0) {
      promocionActual = totalPromociones - 1;
    } else if (promocionActual >= totalPromociones) {
      promocionActual = 0;
    }

    actualizarPromocion();
    actualizarIndicadores();

    // Reiniciar el temporizador automático después de cambiar manualmente
    temporizador = setInterval(function () {
      cambiarPromocion(1);
    }, 5000);
  }

  function actualizarPromocion() {
    const imagenes = document.querySelectorAll('.imgPromociones .promocion');
    imagenes.forEach((imagen, index) => {
      imagen.style.display = (index === promocionActual) ? 'block' : 'none';
    });
  }

  function actualizarIndicadores() {
    const indicadores = document.getElementById('indicadores');
    indicadores.innerHTML = ''; // Limpiar indicadores anteriores

    for (let i = 0; i < totalPromociones; i++) {
      const nuevoIndicador = document.createElement('div');
      nuevoIndicador.classList.add('indicador');

      // Resaltar el indicador de la promoción actual
      if (i === promocionActual) {
        nuevoIndicador.classList.add('promocion-actual');
      }

      // Asignar el evento onclick para cambiar a la promoción correspondiente
      nuevoIndicador.onclick = function () {
        cambiarPromocion(i);
      };

      indicadores.appendChild(nuevoIndicador);
    }
  }

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
                <div class="item-menu"><a href="#""><img src="img/InfinitiTech_Universe_logo_shopping.jpg" alt="InfinitiTech Universe Logo" class="logo"></a></div>
                <div class="item-menu"><a href="#">Home</a></div>
                <div class="item-menu"><a href="producto.php">Productos</a></div>
                <div class="item-menu"><a href="contacto_formulario.php">Contacto</a></div>
                <?php if ($nombre) : ?>

                  <div class="item-menu"><a href="#">Carrito</a></div>
                  <div class="item-menu"><a href="funciones/cerrarSesion.php">Cerrar sesión</a></div> 

                <?php else : ?>

                  <div class="item-menu"><a href="usuarioAlta.php">Registrarse</a></div>
                  <div class="item-menu"><a href="inicioSesion.php">Iniciar Sesión</a></div>

                <?php endif; ?>        
      </div>

    </header>

    <h1>InfinitiTech Universe</h1>

    <div class="contenedorPromociones">
        <div class="imgPromociones">
        <?php
          require "admin/funciones/conecta.php";
          $con = conecta();

          // Realizar la consulta a la base de datos para obtener promociones aleatorias
          $consulta = $con->query("SELECT * FROM promociones WHERE eliminado = 0 ORDER BY RAND() LIMIT 3");

          // Mostrar las imágenes de promociones y círculos de indicadores
          $indicePromocion = 0;
          while ($fila = $consulta->fetch_assoc()) {
            $nombre = $fila['nombre'];
            $archivo = $fila['archivo'];
            echo "<img class='promocion' src='admin/promociones/archivos/$archivo' alt='$nombre' style='display: none;'>";
            $indicePromocion++;
          }
        ?>

          <!-- Botones de navegación -->
          <button class="botonNavegacion botonAnterior" onclick="cambiarPromocion(-1)">&#8249;</button>
          <button class="botonNavegacion botonSiguiente" onclick="cambiarPromocion(1)">&#8250;</button>

          <!-- Contenedor de indicadores centrados en la parte inferior -->
          <div class="contenedorIndicadores" id="indicadores"></div>
  </div>

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
</div>

    <footer>
      <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
      <p>Contacto: info@misitioweb.com</p>
    </footer>

  </body>

</html>