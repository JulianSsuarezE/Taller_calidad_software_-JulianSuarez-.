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

$id = (int)$_GET['id']; // CAST seguro

// ➤ Obtener datos del producto (PDO)
$stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    echo "Producto no encontrado";
    exit;
}

// ➤ Obtener tipos para el <select>
$tiposStmt = $conexion->query("SELECT id, nombre FROM tipos_productos");
$tipos = $tiposStmt->fetchAll(PDO::FETCH_ASSOC);

// ➤ Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $tipo_id = $_POST['tipo_id'] ?? 0;

    $updateStmt = $conexion->prepare("
        UPDATE productos SET 
            nombre = :nombre,
            descripcion = :descripcion,
            precio = :precio,
            stock = :stock,
            tipo_id = :tipo_id
        WHERE id = :id
    ");

    $success = $updateStmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':stock' => $stock,
        ':tipo_id' => $tipo_id,
        ':id' => $id
    ]);

    if ($success) {
        header("Location: index.php?msg=editado");
        exit;
    } else {
        echo "Error actualizando";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../../assets/css/productos/produedit.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="../../assets/img/logo.png" alt="Logo Piñatería">
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
        <h1>Editar Producto</h1>

        <form method="POST" class="form-producto">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

            <label>Descripción:</label>
            <textarea name="descripcion" rows="4"><?= htmlspecialchars($producto['descripcion']) ?></textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>

            <label>Tipo:</label>
            <select name="tipo_id" required>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= ($t['id'] == $producto['tipo_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="index.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería · Todos los derechos reservados.</p>
    </footer>

</body>
</html>
