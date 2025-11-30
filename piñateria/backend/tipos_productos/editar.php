<?php
require '../../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    try {
        $stmt = $conexion->prepare("
            UPDATE tipos_productos
            SET nombre = :nombre, descripcion = :descripcion
            WHERE id = :id
        ");

        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':id' => $id
        ]);

        echo json_encode(['success' => true, 'message' => 'Tipo editado']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
