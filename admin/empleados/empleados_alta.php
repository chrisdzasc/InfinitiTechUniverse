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
    <title>Nuevo empleado</title>

    <link rel="stylesheet" href="css/empleados_alta.css">

    <script src="../funciones/jquery-3.3.1.min.js"></script>

    <script>
    function validar() {
        var correo = document.Forma01.correo.value;
        var pass = document.Forma01.pass.value;
        var rol = document.Forma01.rol.value;
        var nombre = document.Forma01.nombre.value;
        var apellidos = document.Forma01.apellidos.value;
        var archivo = document.Forma01.archivo.value;

        if (correo === "" || pass === "" || rol == 0 || nombre === "" || apellidos === "" || archivo == "") {
            faltanCampos();
        } else {
                document.Forma01.method = 'post';
                document.Forma01.action = 'funciones/empleados_salva.php';
                document.Forma01.submit();
        }
    }

    function faltanCampos() {
        $('#mensaje').html('Faltan campos por llenar');
        setTimeout(function() {
            $('#mensaje').html('');
        }, 5000);
    }

    function validarCorreoExistente() {
        var correo = $('#correo').val();

        $.ajax({
            url         :  'funciones/verificaCorreo.php?correo='+correo,
            type        :  'post',
            dataType    :  'text',
            data        :  'correo='+correo,
            success     :  function(res) {
                console.log(res);
                if (res === 'existe') {
                    $('#mensaje2').html('El correo ' + correo + ' ya existe.');
                    setTimeout("$('#mensaje2').html('');", 5000);
                } else {
                    $('#mensaje2').html('El correo no existe');
                    setTimeout("$('#mensaje2').html('');", 5000);
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

    <h1>Alta de empleados</h1>

    <div class="fila">
        <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
        <div class="item-menu"><a href="empleados_lista.php">Empleados</a></div>
        <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
        <div class="item-menu"><a href="../promociones/promociones_lista.php">Promociones</a></div>
        <div class="item-menu"><a href="">Pedidos</a></div>
        <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesión</a></div>
    </div>

    <a href="empleados_lista.php" class="regresar">Regresar al listado</a>

    <form enctype="multipart/form-data" action="empleados_salva.php" name="Forma01" id="Forma01" method="POST">

        <input type="text" name="nombre" id="nombre" placeholder="Nombre" /> <br>
        <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" /> <br>
        <input type="text" name="correo" id="correo" placeholder="Correo" onBlur="validarCorreoExistente();" />
        <div id="mensaje2"></div>
        <input type="text" name="pass" id="pass" placeholder="Contraseña" /> <br>
        <input type="file" id="archivo" name="archivo">
        <select name="rol" id="rol">
            <option value="0">Selecciona un rol</option>
            <option value="1">Gerente</option>
            <option value="2">Ejecutivo</option>
        </select>

        <input type="submit" value="Enviar" onclick="validar(); return false;" />
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