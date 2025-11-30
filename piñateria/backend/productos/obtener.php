<?php
require '../../config/conexion.php';

try {
    $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, t.nombre AS tipo
            FROM productos p
            INNER JOIN tipos_productos t ON p.tipo_id = t.id";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
