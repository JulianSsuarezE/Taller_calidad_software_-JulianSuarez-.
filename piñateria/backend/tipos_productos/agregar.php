<?php
include '../../../config/conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare("INSERT INTO tipos_productos (nombre, descripcion) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $descripcion);

    if($stmt->execute()){
        echo json_encode(['success' => true, 'message' => 'Tipo agregado']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
}
