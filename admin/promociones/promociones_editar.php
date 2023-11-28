<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start(); 
    header('Content-Type: text/html; charset=utf-8');

    session_start();
    $nombre = isset($_SESSION['nombreUser']) ? $_SESSION['nombreUser'] : null;
?>

<?php
require "../funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "SELECT * FROM promociones WHERE id = $id";
    $result = $con->query($query);

    if ($result) {
        $promociones = $result->fetch_assoc();
        $nombre = $promociones["nombre"];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edición de Promociones</title>

    <link rel="stylesheet" href="css/promociones_editar.css">

    <script src="../funciones/jquery-3.3.1.min.js"></script>

    <script>
        function validar() {
            var nombre = document.Forma01.nombre.value;
            var archivo = document.Forma01.archivo.value;

            if (nombre === "") {
                faltanCampos();
            } else {
                    document.Forma01.method = 'post';
                    document.Forma01.action = 'funciones/promociones_actualiza.php';
                    document.Forma01.submit();
                }

            }

        function faltanCampos() {
            $('#mensaje').html('Faltan campos por llenar');
            setTimeout(function() {
                $('#mensaje').html('');
            }, 5000);
        }
    </script>
</head>

<body>

<?php
    if (isset($nombre)) {
?>
    <h1>Edición de Promociones</h1>

   <div class="fila">
        <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
        <div class="item-menu"><a href="../empleados/empleados_lista.php">Empleados</a></div>
        <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
        <div class="item-menu"><a href="promociones_lista.php">Promociones</a></div>
        <div class="item-menu"><a href="">Pedidos</a></div>
        <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesion</a></div> 
    </div>

    <a href="promociones_lista.php" class="regresar">Regresar al listado</a>

    <form enctype="multipart/form-data" action="funciones/promociones_actualiza.php" name="Forma01" id="Forma01" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>" /><br>
        <input type="file" id="archivo" name="archivo">

        <input type="submit" value="Guardar Cambios" onclick="validar(); return false;" />
        <div id="mensaje"></div>
    </form>

    <?php
    } else {
        header("Location: ../index.php");
        exit();
    }

    ob_end_flush();
?>
</body>

</html>