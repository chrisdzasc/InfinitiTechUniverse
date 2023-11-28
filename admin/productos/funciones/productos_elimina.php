<?php
require "../../funciones/conecta.php";
$con = conecta();

    $id = $_REQUEST['id'];

    $query = "UPDATE productos SET eliminado = 1 WHERE id = $id";
    $sql = $con->query($query);

    if($sql){
        echo "eliminado";
    }else{
        echo "Error";
    }
?>
