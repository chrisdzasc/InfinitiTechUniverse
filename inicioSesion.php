<html>
    <head>
        <title>Log In</title>

        <link rel="stylesheet" href="css/inicioSesion.css">

        <script src="admin/funciones/jquery-3.3.1.min.js"></script>

        <script>
            function validar() {
                var correo = document.Forma01.correo.value;
                var pass = document.Forma01.pass.value;

                if (correo === "" || pass === "") {
                    faltanCampos();
                } else {
                    $.ajax({
                        url         : 'funciones/validaUsuario.php?correo='+correo+ '&pass='+pass,
                        type        : 'post',
                        datatype    : 'text',
                        success     : function (res) {
                            console.log(res);
                            if (parseInt(res) === 1) {
                                window.location.href = "index.php";
                            } else {
                                $('#mensaje2').html('Claves incorrectas');
                                setTimeout(function () {
                                    $('#mensaje2').html('');
                                }, 5000);
                            }
                        }
                    });
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

        <header>
            <nav>
                <ul>
                <li><a href="index.php""><img src="img/InfinitiTech_Universe_logo_shopping.jpg" alt="InfinitiTech Universe Logo" class="logo"></a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Carrito</a></li>  
                </ul>
            </nav>
        </header>

            <h1>Login</h1>

            <div class="contenedor">
                <form name="Forma01" id="Forma01">
                    <input type="text" name="correo" id="correo" placeholder="Escribe tu correo" /> <br>
                    <input type="text" name="pass" id="pass" placeholder="Escribe tu contraseña" /> <br>

                    <div id="mensaje2"></div>
                    <div id="mensaje"></div>

                    <input type="submit" value="Enviar" onclick="validar(); return false;" />
                </form>
            </div>

            <footer>
                <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
                <p>Contacto: info@misitioweb.com</p>
            </footer>
    </body>

</html>