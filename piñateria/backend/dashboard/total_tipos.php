<?php
require_once '../../config/conexion.php';

$sql = "SELECT COUNT(*) AS total FROM tipos_productos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
