<?php
require "../admin/funciones/conecta.php";

$idProducto = $_POST['idProducto'];
$cantidadVendida = $_POST['cantidadVendida'];

$con = conecta();

// Actualizar el stock
$query = "UPDATE productos SET stock = stock - ? WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $cantidadVendida, $idProducto);
$stmt->execute();
$stmt->close();

// Puedes devolver una respuesta al cliente si es necesario
echo 'success';
?>
