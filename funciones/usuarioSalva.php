<?php
require "../admin/funciones/conecta.php";
$con = conecta();

$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$fechaNacimiento = $_REQUEST['fechaNacimiento'];
$fechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
$genero = $_REQUEST['genero'];
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];

$passEnc = md5($pass); //Se almacena la cadena encriptada

$sql = "INSERT INTO usuarios (nombre, apellidos, fechaNacimiento, genero, correo, pass)
        VALUES ('$nombre', '$apellidos', '$fechaNacimiento', '$genero', '$correo', '$passEnc')";

$res = $con->query($sql);

header("Location: ../index.php");
?>