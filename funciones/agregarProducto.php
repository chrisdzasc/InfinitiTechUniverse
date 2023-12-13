<?php
session_start();

if (!isset($_SESSION['idUser'])) {
    echo "Error: No hay una sesión activa.";
    exit;
}

require "../admin/funciones/conecta.php";
$con = conecta();

$idP  = $_REQUEST['idP'];
$cant = $_REQUEST['cant'];

$id_cliente = $_SESSION['idUser'];

$sql = "SELECT * FROM pedidos WHERE id_usuario = ? AND status = 0";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_cliente); 
$stmt->execute();
$res = $stmt->get_result();

if (!$res) {
    echo "Error al ejecutar la consulta: " . $con->error;
    exit;
}

$num = $res->num_rows;

if ($num == 0) {
    $fecha = date('Y-m-d H:i:s'); 
    $sql   = "INSERT INTO pedidos (fecha, id_usuario, status) VALUES (?, ?, 0)";
    $stmt  = $con->prepare($sql);
    $stmt->bind_param("si", $fecha, $id_cliente);
    $stmt->execute();

    if (!$stmt) {
        echo "Error al insertar el nuevo pedido: " . $con->error;
        exit;
    }

    $id_pedido = $con->insert_id;
} else {
    $row      = $res->fetch_assoc();
    $id_pedido = $row['id_pedido'];
}

// Obtener precio
$sql = "SELECT costo FROM productos WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idP);
$stmt->execute();
$res = $stmt->get_result();

if (!$res) {
    echo "Error al ejecutar la consulta: " . $con->error;
    exit;
}

$num = $res->num_rows;

if ($num > 0) {
    $row    = $res->fetch_assoc();
    $precio = $row['costo'];
} else {
    echo "Error: No se encontró el producto.";
    exit;
}

if ($cant > 0) {
    $sql = "SELECT * FROM pedidos_producto
            WHERE id_producto = ? AND id_pedido = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $idP, $id_pedido); 
    $stmt->execute();
    $res = $stmt->get_result();

    if (!$res) {
        echo "Error al ejecutar la consulta: " . $con->error;
        exit;
    }

    $num = $res->num_rows;

    if ($num == 0) {
        $sql = "INSERT INTO pedidos_producto (id_pedido, id_producto, cantidad, costo)
                VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiid", $id_pedido, $idP, $cant, $precio);
    } else {
        $sql = "UPDATE pedidos_producto SET cantidad = cantidad + ?
                WHERE id_pedido = ? AND id_producto = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii", $cant, $id_pedido, $idP);
    }

    $stmt->execute();

    if (!$stmt) {
        echo "Error al ejecutar la consulta: " . $con->error;
        exit;
    }

    echo 1;
} else {
    echo "Error: La cantidad debe ser mayor que cero.";
}

$stmt->close();
$con->close();
?>
