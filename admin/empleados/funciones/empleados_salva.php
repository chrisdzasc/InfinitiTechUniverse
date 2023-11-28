<?php
//empleados_salva.php;
require "../../funciones/conecta.php";
$con = conecta();

$file_name = $_FILES['archivo']['name'];
$file_tmp = $_FILES['archivo']['tmp_name'];
$arreglo = explode(".", $file_name);
$len = count($arreglo);
$pos = $len - 1;
$ext = $arreglo[$pos];
$dir = "archivos/";
$file_enc = md5_file($file_tmp);

if($file_name != ''){
        $fileName1 = "$file_enc.$ext";
        copy($file_tmp, $dir.$fileName1);
}

$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$rol = $_REQUEST['rol'];
$archivo_n = $file_name;
$archivo = $fileName1;
$passEnc = md5($pass); //Se almacena la cadena encriptada

$sql = "INSERT INTO empleados (nombre, apellidos, correo, pass, rol, archivo_n, archivo)
        VALUES ('$nombre', '$apellidos', '$correo', '$passEnc', '$rol', '$archivo_n', '$archivo')";

$res = $con->query($sql);

header("Location: ../empleados_lista.php");
?>