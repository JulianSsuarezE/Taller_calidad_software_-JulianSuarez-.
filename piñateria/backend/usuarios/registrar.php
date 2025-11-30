<?php
session_start();
include '../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Verificar si ya existe el usuario
    $check = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Este correo ya está registrado.";
        header("Location: ../../frontend/usuarios/registrar.php");
        exit;
    }

    // Registrar usuario
    $sql = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        header("Location: ../../frontend/usuarios/login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error al registrar usuario.";
        header("Location: ../../frontend/usuarios/registrar.php");
        exit;
    }
}
?>
