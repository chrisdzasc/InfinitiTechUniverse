<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();
    header('Content-Type: text/html; charset=utf-8');

    session_start();
    $nombre = isset($_SESSION['nombreUser']) ? $_SESSION['nombreUser'] : null;
?>

<html>
    <head>
        
        <title>Detalles del empleado</title>
        
        <link rel="stylesheet" href="css/empleados_detalle.css">

    </head>

    <body>

    <?php
        if (isset($nombre)) {
    ?>
        <div class="header">
            <h1>Detalles del Empleado</h1>
        </div>

        <div class="fila">
            <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
            <div class="item-menu"><a href="empleados_lista.php">Empleados</a></div>
            <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
            <div class="item-menu"><a href="../promociones/promociones_lista.php">Promociones</a></div>
            <div class="item-menu"><a href="">Pedidos</a></div>
            <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesion</a></div> 
        </div>

        <div class="boton">
                <a href="empleados_lista.php" class="button">Regresar al listado</a>
            </div>

        <div class="container">
            <div class="empleadoDetalle">
            <?php
                require "../funciones/conecta.php";

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $con = conecta();

                    $query = "SELECT nombre, apellidos, correo, rol, status, archivo FROM empleados WHERE id = ? AND status = 1 AND eliminado = 0";

                    if ($stmt = $con->prepare($query)) {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($nombre, $apellidos, $correo, $rol, $status, $archivo);

                        if ($stmt->fetch()) {
                            echo "<p>Nombre: $nombre $apellidos</p>";
                            echo "<p>Correo: $correo</p>";
                            echo "<p>Rol: $rol</p>";
                            echo "<p>Status: " . ($status === 1 ? 'Activo' : 'Inactivo') . "</p>";

                            if (!empty($archivo)) {
                                $photoPath = "archivos/" . $archivo;
                                echo "<div style='text-align: center;'><img src='$photoPath' alt='Foto del Empleado' style='max-width: 500px; max-height: 500px;'></div>";
                            } else {
                                echo "<p>No hay foto disponible.</p>";
                            }
                        } else {
                            echo "Empleado no encontrado o no está activo.";
                        }

                        $stmt->close();
                    } else {
                        echo "Error en la consulta.";
                    }
                } else {
                    echo "ID de empleado no proporcionado.";
                }

                $con->close();
                ?>

            </div>
        </div>

        <?php
        } else {
            header("Location: ../index.php");
            exit();
        }

        ob_end_flush();
    ?>
    </body>
</html>