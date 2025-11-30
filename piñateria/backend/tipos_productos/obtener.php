<?php
include '../../../config/conexion.php';

$resultado = $conexion->query("SELECT * FROM tipos_productos ORDER BY id DESC");
$tipos = [];
while($row = $resultado->fetch_assoc()){
    $tipos[] = $row;
}

echo json_encode($tipos);
