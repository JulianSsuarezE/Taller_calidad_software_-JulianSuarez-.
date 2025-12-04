<?php
require_once '../../config/conexion.php';

try {
    $sql = "SELECT SUM(total) AS ganancias FROM ventas";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['ganancias' => 0, 'error' => $e->getMessage()]);
}
?>
