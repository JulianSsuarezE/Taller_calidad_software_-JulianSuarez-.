<?php
require_once '../../config/conexion.php';

$sql = "SELECT COUNT(*) AS total FROM ventas";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
