<?php
require "../../funciones/conecta.php";
$con = conecta();

$codigo = $_REQUEST['codigo'];

$sql = "SELECT COUNT(*) as count FROM productos WHERE codigo = '$codigo'";
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