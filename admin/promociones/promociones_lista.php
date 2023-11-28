<?php 
    session_start();
    $nombre = $_SESSION['nombreUser'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modulo de Promociones</title>

        <link rel="stylesheet" href="css/promociones_lista.css">

        <script src="../funciones/jquery-3.3.1.min.js"></script>

        <script>

            function enviaAjax(id){
                if(confirm("¿Deseas eliminar esta promoción?")){
                    $.ajax({
                        url: 'funciones/promociones_elimina.php?id='+id,
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

                <h1>Listado de Promociones</h1>

                <div class="fila">
                    <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
                    <div class="item-menu"><a href="../empleados/empleados_lista.php">Empleados</a></div>
                    <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
                    <div class="item-menu"><a href="#">Promociones</a></div>
                    <div class="item-menu"><a href="">Pedidos</a></div>
                    <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesión</a></div>
                </div>

                <a href="promociones_alta.php" id="nuevo-empleado">Nueva promoción</a>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Eliminar</th>
                        <th>Detalle</th>
                        <th>Editar</th>
                    </tr>
                    <?php
                        require "../funciones/conecta.php";
                        $con = conecta();

                        $query = "SELECT * FROM promociones WHERE status = 1 AND eliminado = 0";
                        $sql = $con->query($query);

                        while ($row = $sql->fetch_array()) {
                            $id = $row["id"];
                            $nombre = $row["nombre"];
                            
                            echo "<tr>";
                            echo "<td>" . $id . "</td>";
                            echo "<td>" . $nombre . "</td>";
                            echo '<td><a href="javascript:void(0);" onclick="enviaAjax(' . $id . ');">Eliminar</a></td>';
                            echo '<td><a href="promociones_detalle.php?id=' . $id . '">Detalle</a></td>';
                            echo '<td><a href="promociones_editar.php?id=' . $id . '">Editar</a></td>';
                            echo "</tr>";
                        }
                    ?>
                </table>

        <?php
            } else {
                header("Location: ../index.php");
                exit();
            }
        ?>

    </body>
</html>