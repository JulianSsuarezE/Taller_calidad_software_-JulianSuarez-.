<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar usuario</title>
    <link rel="stylesheet" href="../../assets/css/usuarios/registrar.css">
</head>
<body>

    <h1>Crear cuenta</h1>

    <form action="../../backend/usuarios/registrar.php" method="POST">
        <label for="email">Correo:</label>
        <input type="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Registrarse</button>
    </form>

    <!-- Enlace para volver al login -->
    <div class="volver-login">
        <a href="login.php">← Volver al login</a>
    </div>

    <!-- Enlace para volver al inicio -->
    <div class="volver-inicio">
        <a href="../../index.php">← Volver al Inicio</a>
    </div>

    <?php
    if(isset($_SESSION['error'])){
        echo "<p class='error'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>
</body>
</html>
