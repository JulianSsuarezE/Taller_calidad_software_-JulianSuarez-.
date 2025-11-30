<?php
session_start();
include '../../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

// Obtener tipos de productos para el <select>
$tiposStmt = $conexion->query("SELECT id, nombre FROM tipos_productos");
$tipos = $tiposStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../../assets/css/productos/produagre.css">
</head>
<body>

    <!-- NAVBAR -->
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
        <h1>Agregar Producto</h1>

        <!-- Mensaje dinámico -->
        <div id="mensaje"></div>

        <form id="formProducto" class="form-producto">

            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Descripción:</label>
            <textarea name="descripcion" rows="4"></textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" required>

            <label>Stock:</label>
            <input type="number" name="stock" required>

            <label>Tipo de Producto:</label>
            <select name="tipo_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Guardar</button>
                <a href="index.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería · Todos los derechos reservados.</p>
    </footer>

<script>
const form = document.getElementById('formProducto');
const mensajeDiv = document.getElementById('mensaje');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    if (!data.tipo_id) {
        mensajeDiv.textContent = "Selecciona un tipo de producto.";
        mensajeDiv.style.color = "red";
        return;
    }

    try {
        const res = await fetch('../../backend/productos/agregar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        if (result.success) {
            mensajeDiv.textContent = result.message;
            mensajeDiv.style.color = "green";
            form.reset();
        } else {
            mensajeDiv.textContent = "Error: " + result.error;
            mensajeDiv.style.color = "red";
        }
    } catch (err) {
        mensajeDiv.textContent = "Error de conexión: " + err.message;
        mensajeDiv.style.color = "red";
    }
});
</script>

</body>
</html>
