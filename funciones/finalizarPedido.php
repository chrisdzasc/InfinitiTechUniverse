<?php

session_start();

require "../admin/funciones/conecta.php";

$idPedido = isset($_POST['idPedido']) ? $_POST['idPedido'] : null;

$con = conecta();

finalizarPedido($idPedido, $con);

$con->close();

function finalizarPedido($idPedido, $con) {
    $query = "UPDATE pedidos SET status = 1 WHERE id_pedido = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $idPedido);

    $stmt->execute();

    $stmt->close();
}
?>
