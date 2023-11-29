<html>

<head>
    <title>Registro</title>

    <link rel="stylesheet" href="css/usuarioAlta.css">

    <script src="admin/funciones/jquery-3.3.1.min.js"></script>

    <script>
    function validar() {
        var nombre = document.Forma01.nombre.value;
        var apellidos = document.Forma01.apellidos.value;
        var fechaNacimiento = document.Forma01.fechaNacimiento.value;
        var genero = document.Forma01.genero.value;
        var correo = document.Forma01.correo.value;
        var pass = document.Forma01.pass.value;

        if (nombre === "" || apellidos === "" || fechaNacimiento == "" || genero === "" || correo === "" || pass === "") {
            faltanCampos();
        } else {
                document.Forma01.method = 'post';
                document.Forma01.action = 'funciones/usuarioSalva.php';
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
            url         :  'funciones/verificaCorreoUsuario.php?correo='+correo,
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

    <header>
    <div class="fila">
                <div class="item-menu"><a href="index.php"><img src="img/InfinitiTech_Universe_logo_shopping.jpg" alt="InfinitiTech Universe Logo" class="logo"></a></div>
                <div class="item-menu"><a href="index.php">Home</a></div>
                <div class="item-menu"><a href="#">Productos</a></div>
                <div class="item-menu"><a href="#">Contacto</a></div>
                <div class="item-menu"><a href="inicioSesion.php">Iniciar Sesión</a></div> 
      </div>
    </header>

    <h1>Registro</h1>

    <form enctype="multipart/form-data" action="funciones/usuarioSalva.php" name="Forma01" id="Forma01" method="POST">

        <input type="text" name="nombre" id="nombre" placeholder="Nombre" /> <br>
        <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" /> <br>
        <input type="date" name="fechaNacimiento" id="fecha_nacimiento" placeholder="Fecha de Nacimiento" /><br>
        <label for="genero">Género:</label>
        <select name="genero" id="genero">
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
        </select><br>
        <input type="text" name="correo" id="correo" placeholder="Correo" onBlur="validarCorreoExistente();" />
        <div id="mensaje2"></div>
        <input type="text" name="pass" id="pass" placeholder="Contraseña" /> <br>

        <input type="submit" value="Enviar" onclick="validar(); return false;" />
        <div id="mensaje"></div>
    </form>

    <footer>
      <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
      <p>Contacto: info@misitioweb.com</p>
    </footer>
    
</body>

</html>