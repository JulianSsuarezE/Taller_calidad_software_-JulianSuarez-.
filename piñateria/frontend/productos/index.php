<?php
session_start();
include '../../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$sql = "SELECT p.*, t.nombre AS tipo_nombre 
        FROM productos p 
        INNER JOIN tipos_productos t ON p.tipo_id = t.id
        ORDER BY p.id DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="../../assets/css/productos/produindex.css">
</head>
<body>

    <!--NAVBAR -->
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
        <h1>Lista de Productos</h1>

        <a href="agregar.php" class="btn-agregar">Agregar Nuevo Producto</a>

        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Creado en</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['tipo_nombre']) ?></td>
                        <td>$<?= number_format($p['precio'], 2) ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td><?= $p['creado_en'] ?></td>
                        <td>
                            <a href="editar.php?id=<?= $p['id'] ?>" class="editar">Editar</a>
                            <a href="../../backend/productos/eliminar.php?id=<?= $p['id'] ?>"
                               class="eliminar"
                               onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑 Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería · Todos los derechos reservados.</p>
    </footer>

</body>
</html>
