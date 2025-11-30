<?php
session_start();
include '../../config/conexion.php';

// Proteger la vista
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

// Validar ID
if (!isset($_GET['id'])) {
    echo "ID no válido.";
    exit;
}

$id = (int)$_GET['id'];

// Obtener datos del tipo
$stmt = $conexion->prepare("SELECT * FROM tipos_productos WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$tipo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tipo) {
    echo "Tipo no encontrado";
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    $updateStmt = $conexion->prepare("
        UPDATE tipos_productos 
        SET nombre = :nombre, descripcion = :descripcion
        WHERE id = :id
    ");

    $success = $updateStmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':id' => $id
    ]);

    if ($success) {
        header("Location: index.php?msg=editado");
        exit;
    } else {
        echo "Error al actualizar";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tipo de Producto</title>
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
        <h1>Editar Tipo de Producto</h1>

        <form method="POST" class="formulario">
            <div class="campo">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($tipo['nombre']) ?>" required>
            </div>

            <div class="campo">
                <label>Descripción:</label>
                <textarea name="descripcion" rows="4"><?= htmlspecialchars($tipo['descripcion']) ?></textarea>
            </div>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="index.php" class="btn-volver">Volver</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería · Todos los derechos reservados.</p>
    </footer>

</body>
</html>
