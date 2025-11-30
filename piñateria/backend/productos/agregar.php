<?php
require '../../config/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data['nombre'] ?? '';
$descripcion = $data['descripcion'] ?? '';
$precio = $data['precio'] ?? '';
$tipo_id = $data['tipo_id'] ?? '';
$stock = $data['stock'] ?? '';

try {
    $query = "INSERT INTO productos (nombre, descripcion, precio, tipo_id, stock)
              VALUES (:nombre, :descripcion, :precio, :tipo_id, :stock)";
    $stmt = $conexion->prepare($query);

    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':tipo_id' => $tipo_id,
        ':stock' => $stock
    ]);

    echo json_encode(["success" => true, "message" => "Producto agregado"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
