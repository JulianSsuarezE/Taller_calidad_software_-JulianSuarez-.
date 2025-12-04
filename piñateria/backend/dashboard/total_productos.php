<?php
require_once '../../config/conexion.php';

try {
    $sql = "SELECT COUNT(*) AS total FROM productos";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['total' => 0, 'error' => $e->getMessage()]);
}
?>
