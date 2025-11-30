<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Piñatería</title>
    <link rel="stylesheet" href="../../assets/css/usuarios/login.css">
</head>
<body>
    <h1>Iniciar sesión</h1>

    <form action="../../backend/usuarios/verificar.php" method="POST">
        <label for="email">Correo:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Ingresar</button>
    </form>

    <?php
    if(isset($_SESSION['error'])){
        echo "<p class='error'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>

    <!-- Botón para ir a registrar -->
    <div class="ir-registrar">
        <a href="registrar.php">¿No tienes cuenta? Crear cuenta →</a>
    </div>

    <!-- Botón para volver al inicio -->
    <div class="volver-inicio">
        <a href="../../index.php">← Volver al Inicio</a>
    </div>
</body>
</html>
