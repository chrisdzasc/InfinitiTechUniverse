<?php
require "../../funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $costo = $_POST["costo"];
    $stock = $_POST["stock"];

    $queryInfo = "SELECT archivo, archivo_n FROM productos WHERE id = $id";
    $resultadoInfo = $con->query($queryInfo);

    if ($resultadoInfo) {
        $producto = $resultadoInfo->fetch_assoc();
        $fotoExistente = $producto["archivo"];
        $fotoExistenteNombre = $producto["archivo_n"];
    } else {
        echo "Error al obtener la información del empleado.";
        exit();
    }

    if (!empty($_FILES['archivo']['name'])) {
        $file_name = $_FILES['archivo']['name'];
        $file_tmp = $_FILES['archivo']['tmp_name'];
        $arreglo = explode(".", $file_name);
        $len = count($arreglo);
        $pos = $len - 1;
        $ext = $arreglo[$pos];
        $dir = "../archivos/";
        $file_enc = md5_file($file_tmp);
        $fileName1 = "$file_enc.$ext";
        copy($file_tmp, $dir . $fileName1);
    } else {
        $fileName1 = $fotoExistente;
    }

    $query = "UPDATE productos SET nombre='$nombre', codigo='$codigo', descripcion='$descripcion', costo='$costo', stock='$stock'";

    if (!empty($_FILES['archivo']['name'])) {
        $query .= ", archivo_n='$file_name', archivo='$fileName1'";
    }
    
    $query .= " WHERE id='$id'";    

    $result = $con->query($query);

    if ($result) {
        header("Location: ../productos_lista.php");
    } else {
        echo "Error al actualizar el empleado. Por favor, inténtalo de nuevo.";
    }
}
?>