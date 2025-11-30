<?php
session_start();
include '../../config/conexion.php';

// Protege la página
if(!isset($_SESSION['usuario_id'])){
    header("Location: ../../frontend/usuarios/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID no válido";
    exit;
}

$id = (int)$_GET['id'];

try {
    $stmt = $conexion->prepare("DELETE FROM tipos_productos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../../frontend/tipos_productos/index.php?msg=eliminado");
        exit;
    } else {
        echo "❌ Error al eliminar";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
