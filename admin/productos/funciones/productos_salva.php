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
$codigo = $_REQUEST['codigo'];
$descripcion = $_REQUEST['descripcion'];
$costo = $_REQUEST['costo'];
$stock = $_REQUEST['stock'];
$archivo_n = $file_name;
$archivo = $fileName1;

$sql = "INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo_n, archivo)
        VALUES ('$nombre', '$codigo', '$descripcion', '$costo', '$stock', '$archivo_n', '$archivo')";

$res = $con->query($sql);

header("Location: ../productos_lista.php");
?>