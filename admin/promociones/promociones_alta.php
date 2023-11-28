<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    header('Content-Type: text/html; charset=utf-8');

    session_start();
    $nombre = isset($_SESSION['nombreUser']) ? $_SESSION['nombreUser'] : null;
?>


<html>

<head>
    <title>Nueva Promoción</title>

    <link rel="stylesheet" href="css/promociones_alta.css">

    <script src="../funciones/jquery-3.3.1.min.js"></script>

    <script>
    function validar() {
        var nombre = document.Forma01.nombre.value;
        var archivo = document.Forma01.archivo.value;

        if (nombre === "" || archivo == "") {
            faltanCampos();
        } else {
                document.Forma01.method = 'post';
                document.Forma01.action = 'funciones/promociones_salva.php';
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

    <h1>Alta de Promociones</h1>

    <div class="fila">
        <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
        <div class="item-menu"><a href="../empleados/empleados_lista.php">Empleados</a></div>
        <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
        <div class="item-menu"><a href="promociones_lista.php">Promociones</a></div>
        <div class="item-menu"><a href="">Pedidos</a></div>
        <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesión</a></div>
    </div>

    <a href="promociones_lista.php" class="regresar">Regresar al listado</a>

    <form enctype="multipart/form-data" action="funciones/promociones_salva.php" name="Forma01" id="Forma01" method="POST">

        <input type="text" name="nombre" id="nombre" placeholder="Nombre" /> <br>
        <input type="file" id="archivo" name="archivo">

        <input type="submit" value="Enviar" onclick="validar(); return false;" />
        <div id="mensaje"></div>
    </form>

<?php
    } else {
        header("Location: ../index.php");
        exit();
    }

?>
    
</body>

</html>