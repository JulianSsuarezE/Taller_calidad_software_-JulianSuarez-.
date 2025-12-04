<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../usuarios/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Local</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../assets/js/main.js"></script>
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
                <li><a href="../usuarios/dashboard.php">Perfil Usuario</a></li>
                <li><a href="../tipos_productos/index.php">Tipos de Productos</a></li>
                <li><a href="../productos/index.php">Productos</a></li>
                <li><a href="../usuarios/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Dashboard - Estadísticas del Local</h1>

        <!-- Cards -->
        <div class="cards">
            <div class="card" id="totalProductos">Cargando...</div>
            <div class="card" id="totalTipos">Cargando...</div>
            <div class="card" id="totalVentas">Cargando...</div>
            <div class="card" id="gananciasTotales">Cargando...</div>
        </div>

        <!-- Gráfica -->
        <canvas id="ventasPorTipo" width="400" height="200"></canvas>
    </main>

    <script>
    // Total productos
    fetch('../../backend/dashboard/total_productos.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalProductos').textContent = 
            `🧾 Total Productos: ${data.total}`;
    });

    // Total tipos
    fetch('../../backend/dashboard/total_tipos.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalTipos').textContent = 
            `Tipos de Productos: ${data.total}`;
    });

    // Total ventas
    fetch('../../backend/dashboard/total_ventas.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalVentas').textContent = 
            `Ventas Realizadas: ${data.total}`;
    });

    // Ganancias
    fetch('../../backend/dashboard/ganancias_totales.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('gananciasTotales').textContent = 
            `Ganancias Totales: $${data.ganancias ?? 0}`;
    });

    // Ventas por tipo
    fetch('../../backend/dashboard/ventas_por_tipo.php')
    .then(res => res.json())
    .then(data => {

        // Construir arrays
        const tipos = data.map(item => item.tipo);
        const ventas = data.map(item => item.total_ventas);

        const ctx = document.getElementById('ventasPorTipo');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tipos,
                datasets: [{
                    label: 'Ventas por Tipo',
                    data: ventas,
                    backgroundColor: 'rgba(255,140,0,0.7)',
                    borderColor: 'rgba(255,140,0,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>

    <footer>
        <p>&copy; <?= date('Y') ?> Piñatería. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
