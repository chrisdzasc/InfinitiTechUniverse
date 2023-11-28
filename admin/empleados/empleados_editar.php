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

    $query = "SELECT * FROM empleados WHERE id = $id";
    $result = $con->query($query);

    if ($result) {
        $empleado = $result->fetch_assoc();
        $nombre = $empleado["nombre"];
        $apellidos = $empleado["apellidos"];
        $correo = $empleado["correo"];
        $rol = $empleado["rol"];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edición de empleado</title>

    <link rel="stylesheet" href="css/empleados_editar.css">

    <script src="../funciones/jquery-3.3.1.min.js"></script>

    <script>
        function validar() {
            var correo = document.Forma01.correo.value;
            var pass = document.Forma01.pass.value;
            var rol = document.Forma01.rol.value;
            var nombre = document.Forma01.nombre.value;
            var apellidos = document.Forma01.apellidos.value;
            var archivo = document.Forma01.archivo.value;

            if (correo === "" || rol == 0 || nombre === "" || apellidos === "") {
                faltanCampos();
            } else {
                document.Forma01.method = 'post';
                document.Forma01.action = 'funciones/empleados_actualiza.php';
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
                url: 'funciones/verificaCorreo.php?correo=' + correo,
                type: 'post',
                dataType: 'text',
                data: 'correo=' + correo,
                success: function(res) {
                    console.log(res);
                    if (res === 'existe') {
                        $('#mensaje2').html('El correo ' + correo + ' ya existe.');
                        setTimeout(function() {
                            $('#mensaje2').html('');
                        }, 5000);
                    } else {
                        $('#mensaje2').html('El correo no existe');
                        setTimeout(function() {
                            $('#mensaje2').html('');
                        }, 5000);
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
    <h1>Edición de empleado</h1>

   <div class="fila">
        <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
        <div class="item-menu"><a href="empleados_lista.php">Empleados</a></div>
        <div class="item-menu"><a href="../productos/productos_lista.php">Productos</a></div>
        <div class="item-menu"><a href="../promociones/promociones_lista.php">Promociones</a></div>
        <div class="item-menu"><a href="">Pedidos</a></div>
        <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesion</a></div> 
    </div>

    <a href="empleados_lista.php" class="regresar">Regresar al listado</a>

    <form enctype="multipart/form-data" action="empleados_actualiza.php" name="Forma01" id="Forma01" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>" /><br>
        <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php echo $apellidos; ?>" /><br>
        <input type="text" name="correo" id="correo" placeholder="Correo" value="<?php echo $correo; ?>" onBlur="validarCorreoExistente();" />
        <div id="mensaje2"></div>
        <input type="text" name="pass" id="pass" placeholder="Contraseña" /><br>
        <input type="file" id="archivo" name="archivo">
        <select name="rol" id="rol">
            <option value="0">Selecciona un rol</option>
            <option value="1" <?php if ($rol == 1) echo 'selected'; ?>>Gerente</option>
            <option value="2" <?php if ($rol == 2) echo 'selected'; ?>>Ejecutivo</option>
        </select>

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
