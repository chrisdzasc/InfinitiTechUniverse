<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    header('Content-Type: text/html; charset=utf-8');

    session_start();
    $nombre = isset($_SESSION['nombreUser']) ? $_SESSION['nombreUser'] : null;
?>


<html>

<head>
    <title>Nuevo Producto</title>

    <link rel="stylesheet" href="css/productos_alta.css">

    <script src="../funciones/jquery-3.3.1.min.js"></script>

    <script>
    function validar() {
        var nombre = document.Forma01.nombre.value;
        var codigo = document.Forma01.codigo.value;
        var descripcion = document.Forma01.descripcion.value;
        var costo = document.Forma01.costo.value;
        var stock = document.Forma01.stock.value;
        var archivo = document.Forma01.archivo.value;

        if (nombre === "" || codigo === "" || descripcion == 0 || costo === "" || stock === "" || archivo == "") {
            faltanCampos();
        } else {
            validarCodigoExistente();
        }
    }

    function faltanCampos() {
        $('#mensaje').html('Faltan campos por llenar');
        setTimeout(function() {
            $('#mensaje').html('');
        }, 5000);
    }

    function validarCodigoExistente() {
        var codigo = $('#codigo').val();

        $.ajax({
            url         :  'funciones/verificaCodigo.php?codigo='+codigo,
            type        :  'post',
            dataType    :  'text',
            data        :  'codigo='+codigo,
            success     :  function(res) {
                console.log(res);
                if (res === 'existe') {
                    $('#mensaje2').html('El codigo ' + codigo + ' ya existe.');
                    setTimeout("$('#mensaje2').html('');", 5000);
                } else {
                    document.Forma01.method = 'post';
                    document.Forma01.action = 'funciones/productos_salva.php';
                    document.Forma01.submit();
                }
            }
        });
    }
</script>

</head>

<body>

<?php
    if (isset($nombre)) {
?>

    <h1>Alta de Productos</h1>

    <div class="fila">
        <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
        <div class="item-menu"><a href="../empleados/empleados_lista.php">Empleados</a></div>
        <div class="item-menu"><a href="productos_lista.php">Productos</a></div>
        <div class="item-menu"><a href="../promociones/promociones_lista.php">Promociones</a></div>
        <div class="item-menu"><a href="">Pedidos</a></div>
        <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesión</a></div>
    </div>

    <a href="productos_lista.php" class="regresar">Regresar al listado</a>

    <form enctype="multipart/form-data" action="funciones/productos_salva.php" name="Forma01" id="Forma01" method="POST">

        <input type="text" name="nombre" id="nombre" placeholder="Nombre" /> <br>
        <input type="text" name="codigo" id="codigo" placeholder="Código"/> <br>
        <div id="mensaje2"></div>
        <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" />
        <input type="text" name="costo" id="costo" placeholder="Costo" /> <br>
        <input type="text" name="stock" id="stock" placeholder="Stock" /> <br>
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