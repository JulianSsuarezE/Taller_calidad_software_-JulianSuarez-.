// Función para manejar errores de fetch
function fetchJson(url) {
    return fetch(url)
        .then(res => {
            if (!res.ok) throw new Error(`Error al cargar ${url}: ${res.status}`);
            return res.json();
        })
        .catch(err => {
            console.error(err);
            return null;
        });
}

// Total productos
fetchJson('../../backend/dashboard/total_productos.php')
  .then(data => {
      if (data) {
          document.getElementById('totalProductos').textContent = 
              `🧾 Total Productos: ${data.total ?? 0}`;
      }
  });

// Total tipos
fetchJson('../../backend/dashboard/total_tipos.php')
  .then(data => {
      if (data) {
          document.getElementById('totalTipos').textContent = 
              `Tipos de Productos: ${data.total ?? 0}`;
      }
  });

// Total ventas
fetchJson('../../backend/dashboard/total_ventas.php')
  .then(data => {
      if (data) {
          document.getElementById('totalVentas').textContent = 
              `Ventas Realizadas: ${data.total ?? 0}`;
      }
  });

// Ganancias totales
fetchJson('../../backend/dashboard/ganancias_totales.php')
  .then(data => {
      if (data) {
          document.getElementById('gananciasTotales').textContent = 
              `Ganancias Totales: $${data.ganancias ?? 0}`;
      }
  });

// Ventas por tipo (gráfica)
fetchJson('../../backend/dashboard/ventas_por_tipo.php')
  .then(data => {
      if (!data || data.length === 0) return;

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

// Top 5 productos vendidos
fetchJson('../../backend/dashboard/top_productos.php')
  .then(data => {
      if (!data || data.length === 0) return;

      const container = document.createElement('div');
      container.classList.add('card');
      container.innerHTML = `<h3>Top 5 Productos</h3><ul>${
          data.map(item => `<li>${item.nombre}: ${item.total_vendidos}</li>`).join('')
      }</ul>`;

      document.querySelector('.cards').appendChild(container);
  });
