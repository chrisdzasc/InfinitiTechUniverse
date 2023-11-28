<?php
require "../../funciones/conecta.php";
$con = conecta();

$file_name = $_FILES['archivo']['name'];
$file_tmp = $_FILES['archivo']['tmp_name'];
$arreglo = explode(".", $file_name);
$len = count($arreglo);
$pos = $len - 1;
$ext = $arreglo[$pos];
$dir = "../archivos/";
$file_enc = md5_file($file_tmp);

if($file_name != ''){
        $fileName1 = "$file_enc.$ext";
        copy($file_tmp, $dir.$fileName1);
}

$nombre = $_REQUEST['nombre'];
$archivo = $fileName1;

$sql = "INSERT INTO promociones (nombre, archivo)
        VALUES ('$nombre', '$archivo')";

$res = $con->query($sql);

header("Location: ../promociones_lista.php");
?>