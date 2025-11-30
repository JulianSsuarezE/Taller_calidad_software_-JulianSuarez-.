<?php
session_start();
include '../../config/conexion.php';

// Protege la página (solo usuarios logueados pueden verla)
if(!isset($_SESSION['usuario_id'])){
    header("Location: ../usuarios/login.php");
    exit;
}

// Obtener todos los tipos de la BD
$sql = "SELECT * FROM tipos_productos ORDER BY id DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tipos de Productos</title>
    <link rel="stylesheet" href="../../assets/css/tipos_productos/tipoPindex.css">
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
        <h1>Tipos de Productos</h1>

        <a href="agregar.php" class="btn-agregar">Agregar Nuevo Tipo</a>

        <table class="tabla-tipos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $tipo): ?>
                    <tr>
                        <td><?= $tipo['id'] ?></td>
                        <td><?= htmlspecialchars($tipo['nombre']) ?></td>
                        <td><?= htmlspecialchars($tipo['descripcion']) ?></td>
                        <td><?= $tipo['creado_en'] ?></td>
                        <td>
                            <a href="editar.php?id=<?= $tipo['id'] ?>" class="editar">Editar</a>
                            <a href="../../backend/tipos_productos/eliminar.php?id=<?= $tipo['id'] ?>"
                               class="eliminar"
                               onclick="return confirm('¿Seguro que deseas eliminar este tipo?');">Eliminar</a>
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
