<?php 
    session_start();
    $nombre = isset($_SESSION['nombreUser']) ? $_SESSION['nombreUser'] : null;

    if(isset($nombre)) {
        header("Location: bienvenido.php");
        exit();
    }
?>

<html>
    <head>
        <title>Sistema de Administración</title>

        <style>
            h1 {
                background-color: #0074D9;
                color: #ffffff;
                padding: 10px;
            }

            body {
                font-family: 'Arial', sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
            }

            a {
                text-decoration: none;
                color: #007BFF;
                margin: 10px;
            }

            form {
                background-color: #ffffff;
                max-width: 400px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                padding: 30px;
                display: flex;
                flex-direction: column;
            }

            input[type="text"],
            select {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }

            select {
                height: 40px;
            }

            input[type="submit"] {
                background-color: #007BFF;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 15px;
                cursor: pointer;
                font-size: 18px;
            }

            input[type="submit"]:hover {
                background-color: #0056b3;
            }

            #mensaje2 {
                color: #f00;
                font-size: 18px;
            }

            #mensaje{
                color: #f00;
                font: size 18px;
            }
        </style>

        <script src="funciones/jquery-3.3.1.min.js"></script>

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
                                window.location.href = "bienvenido.php";
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
        <?php
            if(isset($nombre)) {
                header("Location: bienvenido.php");
                exit();
            } else {
        ?>
        <h1>Login</h1>

        <form name="Forma01" id="Forma01">
            <input type="text" name="correo" id="correo" placeholder="Escribe tu correo" /> <br>
            <input type="text" name="pass" id="pass" placeholder="Escribe tu contraseña" /> <br>

            <div id="mensaje2"></div>
            <div id="mensaje"></div>

            <input type="submit" value="Enviar" onclick="validar(); return false;" />
        </form>
        <?php
            }
        ?>
    </body>
</html>
