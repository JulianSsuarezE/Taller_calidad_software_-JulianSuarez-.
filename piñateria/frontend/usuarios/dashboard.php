<?php
session_start();

// Si NO está logeado, lo mandamos al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../../config/conexion.php';

// Se busca la información del usuario
$id = $_SESSION['usuario_id'];

try {
    $sql = "SELECT nombre, email, rol, creado_en FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error al obtener la información del usuario: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Dashboard Usuario</title>
    <link rel="stylesheet" href="../../assets/css/dashboard/dashboard.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="../../assets/img/logo.png" alt="Logo Piñatería" style="max-width:100px; height:auto;" />
        </div>
        <nav>
            <ul>
                <li><a href="../../index.php">Inicio</a></li>
                <?php if($_SESSION['rol'] === 'admin'): ?>
                    <li><a href="../dashboard/dashboard.php">Dashboard Admin</a></li>
                <?php endif; ?>
                <li><a href="../tipos_productos/index.php">Tipos de Productos</a></li>
                <li><a href="../productos/index.php">Productos</a></li>
                <li><a href="../usuarios/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1> Bienvenido, <?= htmlspecialchars($usuario['nombre']) ?>!</h1>
        
        <div class="card">
            <h2>Información del Usuario</h2>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($usuario['rol']) ?></p>
            <p><strong>Miembro desde:</strong> <?= htmlspecialchars($usuario['creado_en']) ?></p>
            <a href="../usuarios/logout.php" class="btn-rojo">Cerrar Sesión</a>
        </div>
    </main>
    <br>
    <br>
    <br>
    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
