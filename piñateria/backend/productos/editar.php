<?php
require '../../config/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? '';
$nombre = $data['nombre'] ?? '';
$descripcion = $data['descripcion'] ?? '';
$precio = $data['precio'] ?? '';
$tipo_id = $data['tipo_id'] ?? '';
$stock = $data['stock'] ?? '';

try {
    $query = "UPDATE productos
              SET nombre = :nombre, descripcion = :descripcion,
                  precio = :precio, tipo_id = :tipo_id, stock = :stock
              WHERE id = :id";
    $stmt = $conexion->prepare($query);

    $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':tipo_id' => $tipo_id,
        ':stock' => $stock
    ]);

    echo json_encode(["success" => true, "message" => "Producto actualizado"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
