<?php
session_start();
include '../../config/conexion.php';

// Protege la página (solo usuarios logueados)
if(!isset($_SESSION['usuario_id'])){
    header("Location: ../usuarios/login.php");
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    try {
        $stmt = $conexion->prepare("INSERT INTO tipos_productos (nombre, descripcion) VALUES (:nombre, :descripcion)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
        $mensaje = "Tipo de producto agregado correctamente.";
        $tipoMensaje = "exito";
    } catch (PDOException $e) {
        $mensaje = "Error al agregar: " . $e->getMessage();
        $tipoMensaje = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Tipo de Producto</title>
    <link rel="stylesheet" href="../../assets/css/tipos_productos/tipoPedit.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="../../assets/img/logo.png" alt="Logo Piñatería" />
        </div>
        <nav>
            <ul>
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="../usuarios/dashboard.php">Perfil Usuario</a></li>
                <li><a href="../tipos_productos/index.php">Tipos de Productos</a></li>
                <li><a href="../productos/index.php">Productos</a></li>
                <li><a href="../usuarios/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Agregar Tipo de Producto</h1>

        <?php if(isset($mensaje)): ?>
            <p class="mensaje <?= $tipoMensaje ?>"><?= $mensaje ?></p>
        <?php endif; ?>

        <form method="POST" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre del Tipo:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>

            <div class="campo">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" rows="4"></textarea>
            </div>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Guardar</button>
                <a href="index.php" class="btn-volver">Volver</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería · Todos los derechos reservados.</p>
    </footer>

</body>
</html>
