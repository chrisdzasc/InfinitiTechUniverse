<?php
require "../admin/funciones/conecta.php";
$con = conecta();

$correo = $_REQUEST['correo'];

$sql = "SELECT COUNT(*) as count FROM usuarios WHERE correo = '$correo'";
$result = $con->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $count = $row['count'];

    if ($count > 0) {
        echo 'existe';
    } else {
        echo 'noexiste';
    }
} else {
    echo 'error';
}
?>