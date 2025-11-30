<?php
session_start();
require '../../config/conexion.php';

// Solo procesamos POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // Buscar usuario por email
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Comparamos la contraseña
            if ($password === $usuario['password']) {

                // Guardar datos en sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según rol
                if ($usuario['rol'] === 'admin') {
                    header("Location: ../../frontend/dashboard/dashboard.php"); // Dashboard admin
                    exit;
                } else {
                    header("Location: ../../frontend/usuarios/perfil.php"); // Usuario normal
                    exit;
                }

            } else {
                $_SESSION['error'] = "Contraseña incorrecta";
                header("Location: ../../frontend/usuarios/login.php");
                exit;
            }

        } else {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: ../../frontend/usuarios/login.php");
            exit;
        }

    } catch (PDOException $e) {
        // Error en la consulta
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        header("Location: ../../frontend/usuarios/login.php");
        exit;
    }

} else {
    // Si no es POST, redirigimos al login
    header("Location: ../../frontend/usuarios/login.php");
    exit;
}
