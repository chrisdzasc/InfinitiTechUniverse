<?php 
    session_start();
    $nombre = $_SESSION['nombreUser'];
?>

<html>
<head>
    <style>

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #95736b;
            color: #ffffff;
            padding: 20px;
            margin: 0;
        }

        p {
            background-color: #95736b;
            color: #ffffff;
            padding: 20px;
            margin: 0;
        }

        .nombre {
            font-weight: bold;
            color: black;
        }

        hr {
            border: 1px solid #333;
        }

        .fila {
            display: flex;
            justify-content: space-around;
            background-color: #95736b;
            color: #ffffff;
            padding: 10px;
        }

        .item-menu {
            padding: 10px;
        }

        .item-menu a {
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            transition: color 0.3s;
        }

        .item-menu a:hover {
            color: #ff4d4d;
        }


    </style>
</head>
<body>
    
<?php
        if(isset($nombre)) {
?>
            <h1>Bienvenido al sistema de administración</h1>
            <p>Hola, bienvenido <span class="nombre"><?= $nombre; ?></span></p>

            <div class="fila">
                <div class="item-menu"><a href="bienvenido.php">Inicio</a></div>
                <div class="item-menu"><a href="empleados/empleados_lista.php">Empleados</a></div>
                <div class="item-menu"><a href="productos/productos_lista.php">Productos</a></div>
                <div class="item-menu"><a href="promociones/promociones_lista.php">Promociones</a></div>
                <div class="item-menu"><a href="">Pedidos</a></div>
                <div class="item-menu"><a href="funciones/cerrar_sesion.php">Cerrar sesión</a></div> 
            </div>
    <?php
        } else {
            header("Location: index.php");
            exit();
        }
    ?>

</body>
</html>
