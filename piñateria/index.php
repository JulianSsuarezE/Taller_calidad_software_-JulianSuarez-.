<?php
include 'config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Piñatería - Inicio</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/main.js" defer></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/img/logo.png" alt="Logo Piñatería">
        </div>
        <nav>
            <ul>
                <li><a href="frontend/tipos_productos/index.php">Tipos de Productos</a></li>
                <li><a href="frontend/productos/index.php">Productos</a></li>
                <li><a href="frontend/usuarios/login.php">Login</a></li>
                <li><a href="frontend/dashboard/dashboard.php">Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Bienvenido a la Piñatería</h1>
        <p>Gestiona tus productos y tipos de productos de manera fácil y rápida.</p>

        <section>
            <h2>Opciones rápidas</h2>
            <ul>
                <li><a href="frontend/tipos_productos/agregar.php">Agregar nuevo tipo de producto</a></li>
                <li><a href="frontend/productos/agregar.php">Agregar nuevo producto</a></li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
