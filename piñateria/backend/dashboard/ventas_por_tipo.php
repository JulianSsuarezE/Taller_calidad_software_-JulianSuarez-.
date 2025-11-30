<?php
require_once '../../config/conexion.php';

$sql = "
    SELECT tp.nombre AS tipo, SUM(v.total) AS total_ventas
    FROM ventas v
    JOIN detalle_venta dv ON v.id = dv.venta_id
    JOIN productos p ON dv.producto_id = p.id
    JOIN tipos_productos tp ON p.tipo_id = tp.id
    GROUP BY tp.nombre
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
