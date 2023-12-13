<?php
require "../admin/funciones/conecta.php";
$con = conecta();

$id_producto = isset($_REQUEST['id_producto']) ? $_REQUEST['id_producto'] : null;

$query = "DELETE FROM pedidos_producto WHERE id_producto = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id_producto);

if ($stmt->execute()) {
    echo "eliminado";
} else {
    echo "Error: " . $stmt->error;
}

?>
