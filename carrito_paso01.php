<?php

session_start();
$idUsuario = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : null;

require "admin/funciones/conecta.php";

function obtenerProductosPedidoAbierto($id_pedido, $con) {
    $query = "SELECT pedidos_producto.id_pedido, productos.nombre, pedidos_producto.id_producto, pedidos_producto.cantidad, productos.costo
                FROM pedidos_producto
                JOIN productos ON pedidos_producto.id_producto = productos.id
                WHERE pedidos_producto.id_pedido = ? AND pedidos_producto.eliminado = 0";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id_pedido);
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = [];

    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    $stmt->close();

    return $productos;
}


function obtenerPedidoAbierto($idUsuario, $con) {
    $query = "SELECT id_pedido FROM pedidos WHERE id_usuario = ? AND status = 0";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($idPedido);
    $stmt->fetch();
    $stmt->close();

    return $idPedido;
}

$con = conecta();

$idPedidoAbierto = obtenerPedidoAbierto($idUsuario, $con);
$productosPedido = obtenerProductosPedidoAbierto($idPedidoAbierto, $con);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Pedido</title>

    <link rel="icon" type="image/jpg" href="img/InfinitiTech_Universe_logo_shopping.jpg">


    <link rel="stylesheet" href="css/carrito_paso01.css">

    <script src="admin/funciones/jquery-3.3.1.min.js"></script>

    <script>
        function eliminarProducto(id_producto) {
            if (confirm("¿Deseas eliminar a este producto?")) {
                $.ajax({
                    url: 'funciones/eliminarProducto.php?id_producto=' + id_producto,
                    type: 'post',
                    dataType: 'text',
                    success: function (res) {
                        console.log(res);
                        if (res === 'success') {
                            alert("Eliminado");
                        }
                    }
                });
            }
        }


            function irACarritoPaso02() {
                window.location.href = 'carrito_paso02.php';
    }

    </script>
</head>

<body>

<header>

    <div class="fila">
    <div class="item-menu"><a href="index.php"><img src="img/InfinitiTech_Universe_logo_shopping.jpg" alt="InfinitiTech Universe Logo" class="logo"></a></div>
    <div class="item-menu"><a href="index.php">Home</a></div>
    <div class="item-menu"><a href="producto.php">Productos</a></div>
    <div class="item-menu"><a href="contacto_formulario.php">Contacto</a></div>
    <div class="item-menu"><a href="carrito_paso01.php">Carrito</a></div>
    <div class="item-menu"><a href="funciones/cerrarSesion.php">Cerrar sesión</a></div>
    </div>

    </header>

    <h1>Mi Pedido</h1>

    <div id="listaProductos">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productosPedido as $producto) : ?>
                    <tr>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo $producto['costo']; ?></td>
                        <td><a href="javascript:void(0);" onclick="eliminarProducto(<?php echo $producto['id_producto']; ?>);">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <button id="siguientePaso" onclick="irACarritoPaso02()">Siguiente</button>
    
    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> InfinitiTech Universe. Todos los derechos reservados.</p>
            <p><a href="#">Términos y Condiciones</a></p>
        </div>

        <div class="social-media">
            <p>Síguenos en:</p>
            <ul>
            <li><a href="https://facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a></li>
            <li><a href="https://twitter.com" target="_blank" rel="noopener noreferrer">Twitter</a></li>
            <li><a href="https://instagram.com" target="_blank" rel="noopener noreferrer">Instagram</a></li>
            </ul>
        </div>
    </footer>

</body>

</html>