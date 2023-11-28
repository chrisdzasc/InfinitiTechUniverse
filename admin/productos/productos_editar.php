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

    $query = "SELECT * FROM productos WHERE id = $id";
    $result = $con->query($query);

    if ($result) {
        $producto = $result->fetch_assoc();
        $nombre = $producto["nombre"];
        $codigo = $producto["codigo"];
        $descripcion = $producto["descripcion"];
        $costo = $producto["costo"];
        $stock = $producto["stock"];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edición de Producto</title>

    <link rel="stylesheet" href="css/productos_editar.css">

    <script src="../funciones/jquery-3.3.1.min.js"></script>

    <script>
        function validar() {
            var nombre = document.Forma01.nombre.value;
            var codigo = document.Forma01.codigo.value;
            var descripcion = document.Forma01.descripcion.value;
            var costo = document.Forma01.costo.value;
            var stock = document.Forma01.stock.value;
            var archivo = document.Forma01.archivo.value;

            if (nombre === "" || codigo == 0 || descripcion === "" || costo === "" || stock === "") {
                faltanCampos();
            } else {

                var codigoOriginal = $('#codigo').data('original-code');
                if(codigo !== codigoOriginal){
                    validarCodigoExistente();
                }else{
                    document.Forma01.method = 'post';
                    document.Forma01.action = 'funciones/productos_actualiza.php';
                    document.Forma01.submit();
                }

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
        var codigoOriginal = $('#codigo').data('original-code');

        if (codigo !== codigoOriginal) {
            $.ajax({
                url: 'funciones/verificaCodigo.php?codigo=' + codigo,
                type: 'post',
                dataType: 'text',
                data: 'codigo=' + codigo,
                success: function(res) {
                    console.log(res);
                    if (res === 'existe') {
                        $('#mensaje2').html('El código ' + codigo + ' ya existe.');
                        setTimeout(function() {
                            $('#mensaje2').html('');
                        }, 5000);
                    } else {
                        document.Forma01.method = 'post';
                        document.Forma01.action = 'funciones/productos_actualiza.php';
                        document.Forma01.submit();
                    }
                }
            });
        } else {
            document.Forma01.method = 'post';
            document.Forma01.action = 'funciones/productos_actualiza.php';
            document.Forma01.submit();
        }
}
    </script>
</head>

<body>

<?php
    if (isset($nombre)) {
?>
    <h1>Edición de Producto</h1>

   <div class="fila">
        <div class="item-menu"><a href="../bienvenido.php">Inicio</a></div>
        <div class="item-menu"><a href="../empleados/empleados_lista.php">Empleados</a></div>
        <div class="item-menu"><a href="productos_lista.php">Productos</a></div>
        <div class="item-menu"><a href="../promociones/promociones_lista.php">Promociones</a></div>
        <div class="item-menu"><a href="">Pedidos</a></div>
        <div class="item-menu"><a href="../funciones/cerrar_sesion.php">Cerrar sesion</a></div> 
    </div>

    <a href="productos_lista.php" class="regresar">Regresar al listado</a>

    <form enctype="multipart/form-data" action="empleados_actualiza.php" name="Forma01" id="Forma01" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>" /><br>
        <input type="text" name="codigo" id="codigo" placeholder="Código" value="<?php echo $codigo; ?>" data-original-code="<?php echo $codigo; ?>" />
        <div id="mensaje2"></div>
        <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" value="<?php echo $descripcion; ?>" /><br>
        <input type="text" name="costo" id="costo" placeholder="Costo" value="<?php echo $costo; ?>" /><br>
        <input type="text" name="stock" id="stock" placeholder="Stock" value="<?php echo $stock; ?>" /><br>
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