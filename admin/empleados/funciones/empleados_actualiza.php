<?php
require "../../funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];
    $pass = $_POST["pass"];

    $queryInfo = "SELECT archivo, archivo_n FROM empleados WHERE id = $id";
    $resultadoInfo = $con->query($queryInfo);

    if ($resultadoInfo) {
        $empleado = $resultadoInfo->fetch_assoc();
        $fotoExistente = $empleado["archivo"];
        $fotoExistenteNombre = $empleado["archivo_n"];
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
        $dir = "archivos/";
        $file_enc = md5_file($file_tmp);
        $fileName1 = "$file_enc.$ext";
        copy($file_tmp, $dir . $fileName1);
    } else {
        $fileName1 = $fotoExistente;
    }

    if (!empty($pass)) {
        $passEnc = md5($pass);
        $passUpdate = ", pass='$passEnc'";
    } else {
        $passUpdate = '';
    }

    $query = "UPDATE empleados SET nombre='$nombre', apellidos='$apellidos', correo='$correo', rol='$rol' $passUpdate";

    if (!empty($_FILES['archivo']['name'])) {
        $query .= ", archivo_n='$file_name', archivo='$fileName1'";
    }

    $query .= " WHERE id='$id'";

    $result = $con->query($query);

    if ($result) {
        header("Location: ../empleados_lista.php");
    } else {
        echo "Error al actualizar el empleado. Por favor, inténtalo de nuevo.";
    }
}
?>