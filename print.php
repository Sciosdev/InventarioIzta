<?php
// print.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Resguardo Global SICOP</title>
  <style>
    body {
      margin: 1cm;
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
    }
    h2, h3, h4 {
      text-align: center;
      margin: 0;
    }
    .header h2 { font-size: 16pt; }
    .header h3 { font-size: 14pt; }
    .header h4 { font-size: 12pt; text-transform: uppercase; }

    .info {
      width: 100%;
      margin: 12px 0;
      overflow: hidden;
    }
    .info .left, .info .right {
      display: inline-block;
      vertical-align: top;
      width: 48%;
    }
    .info .right { text-align: right; }
    .info strong { display: inline-block; width: 120px; }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
    }
    th, td {
      border: 1px solid #000;
      padding: 4px 6px;
      font-size: 10pt;
    }
    th { background: #eee; text-transform: uppercase; }

    .firmas {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-top: 90px;
    }
    .firmas > div {
      width: 30%;
      text-align: center;
    }
    .firmas .fecha {
      /* este div queda en el centro */
      width: 30%;
      text-align: center;
      font-style: italic;
    }
    .firmas p { margin: 4px 0; }

    @media print {
      body { margin: 0; padding-bottom: 120px; }
      .firmas {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        margin: 0;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>FACULTAD DE ESTUDIOS SUPERIORES IZTACALA</h2>
    <h3>RESGUARDO GLOBAL SICOP</h3>
    <h4>DEPARTAMENTO DE INVENTARIOS</h4>
  </div>

  <div class="info">
    <div class="left">
      <strong>UNIDAD RESPONSABLE:</strong> <span id="unidad"></span><br>
      <strong>USUARIO DEL BIEN:</strong> <span id="usuario"></span>
    </div>
    <div class="right">
      <strong>RFC:</strong> <span id="rfc"></span><br>
      <strong>PUESTO:</strong> <span id="puesto"></span>
    </div>
  </div>

  <table id="tabla">
    <thead>
      <tr>
        <th>INVENTARIO</th>
        <th>NOMBRE DEL BIEN</th>
        <th>MARCA</th>
        <th>MODELO</th>
        <th>SERIE</th>
        <th>LUGAR</th>
        <th>OBS</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <p style="margin-top:12px;">
    Por medio del presente, resguardo los bienes de Activo Fijo arriba mencionados, propiedad de la Universidad Nacional Autónoma de México. Comprometiéndome a mantenerlos en buenas condiciones e informar cualquier cambio de ubicación o faltante.
  </p>

  <div class="firmas">
    <div class="encargado">
      <p>LIC. ENRIQUE CARREÓN GASPÁR</p>
      <p>ENCARGADO DE ALMACÉN E INVENTARIOS</p>
    </div>
    <div class="fecha">
      <p id="fecha"></p>
    </div>
    <div class="responsable">
      <p id="firma"></p>
      <p>RESPONSABLE DE LOS BIENES</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const raw = sessionStorage.getItem('printData');
      if (!raw) {
        alert('No hay datos para imprimir');
        return;
      }
      const datos = JSON.parse(raw);
      const primero = datos[0];

      // Encabezado
      document.getElementById('unidad').textContent = `${primero.area_id} ${primero.nombre_area}`;
      document.getElementById('usuario').textContent = primero.nombre_responsable;
      document.getElementById('rfc').textContent = primero.rfc_responsable;
      document.getElementById('puesto').textContent = primero.puesto_responsable;

      // Cuerpo de la tabla
      const tbody = document.querySelector('#tabla tbody');
      datos.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${item.numero_inventario}</td>
          <td>${item.descripcion}</td>
          <td>${item.marca}</td>
          <td>${item.modelo}</td>
          <td>${item.numero_serie}</td>
          <td>${item.ubicacion}</td>
          <td>${item.tipobien}</td>
        `;
        tbody.appendChild(tr);
      });

      // Fecha centrada
      const hoy = new Date();
      const opciones = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
      document.getElementById('fecha').textContent =
        hoy.toLocaleDateString('es-ES', opciones);

      // Firma del responsable
      document.getElementById('firma').textContent = primero.nombre_responsable;
    });
  </script>
</body>
</html>
