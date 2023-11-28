<?php 
    session_start();
    $nombre = $_SESSION['nombreUser'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modulo de Empleados</title>

        <link rel="stylesheet" href="css/empleados_lista.css">

        <script src="../funciones/jquery-3.3.1.min.js"></script>

        <script>

            function enviaAjax(id){
                if(confirm("¿Deseas eliminar a este empleado?")){
                    $.ajax({
                        url: 'funciones/empleados_elimina.php?id='+id,
                        type: 'post',
                        dataType    :  'text',
                        
                        success : function(res){
                            console.log(res);
                            if(res === 'success'){
                                alert("Eliminado");
                            }
                        }

                    });
                }
            }

        </script>
    
    </head>
    
    <body>

        <?php
            if(isset($nombre)) {
        ?>

                <h1>Listado de Empleados</h1>

                <div class="fila">
                    <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
                    <div class="item-menu"><a href="empleados_lista.php">Empleados</a></div>
                    <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
                    <div class="item-menu"><a href="../promociones/promociones_lista.php">Promociones</a></div>
                    <div class="item-menu"><a href="">Pedidos</a></div>
                    <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesión</a></div>
                </div>

                <a href="empleados_alta.php" id="nuevo-empleado">Nuevo empleado</a>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Eliminar</th>
                        <th>Detalle</th>
                        <th>Editar</th>
                    </tr>
                    <?php
                        require "../funciones/conecta.php";
                        $con = conecta();

                        $query = "SELECT * FROM empleados WHERE status = 1 AND eliminado = 0";
                        $sql = $con->query($query);

                        while ($row = $sql->fetch_array()) {
                            $id = $row["id"];
                            $nombre = $row["nombre"];
                            $apellidos = $row["apellidos"];
                            $correo = $row["correo"];
                            $rol = $row["rol"];
                            
                            echo "<tr>";
                            echo "<td>" . $id . "</td>";
                            echo "<td>" . $nombre . "</td>";
                            echo "<td>" . $apellidos . "</td>";
                            echo "<td>" . $correo . "</td>";
                            echo "<td>" . $rol . "</td>";
                            echo '<td><a href="javascript:void(0);" onclick="enviaAjax(' . $id . ');">Eliminar</a></td>';
                            echo '<td><a href="empleados_detalle.php?id=' . $id . '">Detalle</a></td>';
                            echo '<td><a href="empleados_editar.php?id=' . $id . '">Editar</a></td>';
                            echo "</tr>";
                        }
                    ?>
                </table>

                <div id="roles">
                    <p>1-Gerente</p>
                    <p>2-Ejecutivo</p>
                </div>

        <?php
            } else {
                header("Location: ../index.php");
                exit();
            }
        ?>


    </body>
</html>