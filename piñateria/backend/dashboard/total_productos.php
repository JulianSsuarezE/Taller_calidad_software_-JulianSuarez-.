<?php
require_once '../../config/conexion.php';

try {
    $sql = "
        SELECT p.nombre, SUM(dv.cantidad) AS total_vendidos
        FROM detalle_venta dv
        JOIN productos p ON dv.producto_id = p.id
        GROUP BY p.nombre
        ORDER BY total_vendidos DESC
        LIMIT 5
    ";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode([]);
}
?>
