<?php
include("auth.php");
include("../includes/config.php");

$conn->set_charset("utf8mb4"); // ← AGREGA ESTA LÍNEA
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- ✅Importar Rokkitt desde Google Fonts (agrega esto) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rokkitt:wght@400;600;700;800&display=swap" rel="stylesheet">
  
  <title>Panel Admin CINET</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background:#f4f6fb; font-family:'Segoe UI',sans-serif; }

    /* HEADER */
    .panel-header {
      background: linear-gradient(135deg,#3b1270 0%,#5A2D91 60%,#7b4db8 100%);
      color:#fff;
      padding:2.2rem 2rem 1.8rem;
      border-radius:0 0 28px 28px;
      margin-bottom:2rem;
    }
    .panel-header h1 { font-size:1.7rem; font-weight:800; margin:0; }
    .panel-header p  { opacity:.78; margin:.3rem 0 0; font-size:.95rem; }

    /* STATS */
    .stat-card {
      background:#fff;
      border-radius:16px;
      padding:1.2rem 1.5rem;
      box-shadow:0 4px 18px rgba(0,0,0,.06);
      display:flex;
      align-items:center;
      gap:1rem;
    }
    .stat-icon {
      width:50px;height:50px;border-radius:12px;
      display:flex;align-items:center;justify-content:center;font-size:1.4rem;
    }
    .stat-icon.purple{background:rgba(91,15,166,.10);color:#5B0FA6;}
    .stat-icon.green {background:rgba(25,135,84,.10); color:#198754;}
    .stat-icon.blue  {background:rgba(13,110,253,.10);color:#0d6efd;}
    .stat-num{font-size:1.6rem;font-weight:800;line-height:1;}
    .stat-lbl{font-size:.82rem;color:#6b7280;margin-top:2px;}

    /* TABLE CARD */
    .table-card {
      background:#fff;
      border-radius:20px;
      box-shadow:0 6px 24px rgba(0,0,0,.06);
      overflow:hidden;
    }
    .card-toolbar {
      padding:1.2rem 1.5rem;
      border-bottom:1px solid #f0f0f0;
      display:flex;align-items:center;gap:1rem;flex-wrap:wrap;
    }
    .search-box { position:relative;flex:1;min-width:220px; }
    .search-box i { position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af; }
    .search-box input {
      padding-left:36px;border-radius:10px;border:1px solid #e5e7eb;
      background:#f9fafb;width:100%;height:40px;font-size:.9rem;
    }
    .search-box input:focus {
      outline:none;border-color:#5B0FA6;background:#fff;
      box-shadow:0 0 0 3px rgba(91,15,166,.08);
    }
    table thead th {
      background:#f8f5ff;color:#3E0A75;font-weight:700;
      font-size:.80rem;text-transform:uppercase;letter-spacing:.04em;
      padding:.85rem 1rem;border-bottom:2px solid #ede9fe;white-space:nowrap;
    }
    table tbody td {
      padding:.85rem 1rem;vertical-align:middle;
      border-bottom:1px solid #f3f4f6;font-size:.9rem;
    }
    table tbody tr:hover { background:#faf5ff; }

    /* BADGES */
    .badge-metodo {
      display:inline-block;padding:4px 10px;
      border-radius:999px;font-size:.75rem;font-weight:700;
    }
    .badge-ach      {background:#ede9fe;color:#5B0FA6;}
    .badge-efectivo {background:#dcfce7;color:#166534;}
    .badge-exento   {background:#fef9c3;color:#854d0e;}

    /* COMPROBANTE */
    .thumb-comp {
      width:46px;height:46px;border-radius:8px;object-fit:cover;cursor:pointer;
      border:2px solid #ede9fe;transition:transform .2s,border-color .2s;
    }
    .thumb-comp:hover { transform:scale(1.08);border-color:#5B0FA6; }
    .no-comp { color:#d1d5db;font-size:.8rem; }
    .modal-comp-img {
      max-width:100%;max-height:78vh;border-radius:12px;display:block;margin:0 auto;
    }

    /* NOMBRE */
    .nombre-principal{font-weight:700;color:#1f2937;}

    /* BOTONES TOP */
    .btn-pdf {
      background:#5B0FA6;color:#fff;border:none;border-radius:10px;
      padding:8px 18px;font-weight:700;font-size:.88rem;
      display:inline-flex;align-items:center;gap:6px;
      text-decoration:none;transition:background .2s;
    }
    .btn-pdf:hover{background:#3E0A75;color:#fff;}
    .btn-salir {
      background:#f1f5f9;color:#374151;border:1px solid #e5e7eb;border-radius:10px;
      padding:8px 16px;font-weight:600;font-size:.88rem;
      display:inline-flex;align-items:center;gap:6px;
      text-decoration:none;transition:background .2s;
    }
    .btn-salir:hover{background:#e2e8f0;color:#111;}
  </style>
</head>
<body>

<?php
/* ── ESTADÍSTICAS ── */
$total    = $conn->query("SELECT COUNT(*) AS n FROM inscripciones")->fetch_assoc()['n'];
$ach      = $conn->query("SELECT COUNT(*) AS n FROM inscripciones WHERE metodo_pago='ACH'")->fetch_assoc()['n'];
$efectivo = $conn->query("SELECT COUNT(*) AS n FROM inscripciones WHERE metodo_pago='Efectivo'")->fetch_assoc()['n'];
$exento   = $conn->query("SELECT COUNT(*) AS n FROM inscripciones WHERE metodo_pago='Exento'")->fetch_assoc()['n'];
?>

<!-- HEADER -->
<div class="panel-header">
  <div class="container-fluid px-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
      <h1><i class="bi bi-people-fill me-2"></i>Panel de Administraci贸n</h1>
      <p>Inscritos al VI Congreso Internacional  <?= date('d/m/Y H:i') ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="exportar_pdf.php" class="btn-pdf">
        <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
      </a>
      <a href="logout.php" class="btn-salir">
        <i class="bi bi-box-arrow-right"></i> Salir
      </a>
    </div>
  </div>
</div>

<div class="container-fluid px-4 pb-5">

  <!-- STATS -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-people"></i></div>
        <div>
          <div class="stat-num"><?= $total ?></div>
          <div class="stat-lbl">Total inscritos</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-bank"></i></div>
        <div>
          <div class="stat-num"><?= $ach ?></div>
          <div class="stat-lbl">Pago ACH</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-cash"></i></div>
        <div>
          <div class="stat-num"><?= $efectivo ?></div>
          <div class="stat-lbl">Efectivo</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-star"></i></div>
        <div>
          <div class="stat-num"><?= $exento ?></div>
          <div class="stat-lbl">Exentos</div>
        </div>
      </div>
    </div>
  </div>

  <!-- TABLA -->
  <div class="table-card">
    <div class="card-toolbar">
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="buscador"
               placeholder="Buscar por nombre, c茅dula o m茅todo de pago">
      </div>
      <span class="text-muted" style="font-size:.85rem;white-space:nowrap;">
        <span id="contadorVisible"><?= $total ?></span> registro(s)
      </span>
    </div>

    <div class="table-responsive">
      <table class="table mb-0" id="tablaInscritos">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre completo</th>
            <th>C茅dula</th>
            <th>Tipo</th>
            <th>Facultad y A帽o</th>
            <th>M茅todo de Pago</th>
            <th>Comprobante</th>
            <th>Fecha Registro</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = $conn->query(
            "SELECT * FROM inscripciones ORDER BY fecha_registro DESC"
          );

          if ($res && $res->num_rows > 0):
            $num = 1;
            while ($f = $res->fetch_assoc()):
              $mp    = htmlspecialchars($f['metodo_pago'] ?? '–');
              $clase = match($f['metodo_pago'] ?? '') {
                'ACH'      => 'badge-ach',
                'Efectivo' => 'badge-efectivo',
                default    => 'badge-exento'
              };

              $comp       = $f['comprobante'] ?? '';
              $rutaFisica = '../' . $comp;
              $rutaWeb    = '../' . $comp;
              $ext        = strtolower(pathinfo($comp, PATHINFO_EXTENSION));
              $esImagen   = in_array($ext, ['jpg','jpeg','png','webp']);
              $esPdf      = ($ext === 'pdf');

              $facAnio = htmlspecialchars($f['facultad'] ?? '–');
              if (!empty($f['anio'])) $facAnio .= ' · ' . $f['anio'];
          ?>
          <tr>
            <td class="text-muted"><?= $num++ ?></td>

            <td>
              <div class="nombre-principal">
                <?= htmlspecialchars(
                  trim(($f['nombre'] ?? '') . ' ' . ($f['apellido'] ?? ''))
                ) ?>
              </div>
            </td>

            <td>
              <span style="font-family:monospace;">
                <?= htmlspecialchars($f['cedula'] ?? '–') ?>
              </span>
            </td>

            <td><?= htmlspecialchars($f['tipo_participante'] ?? '–') ?></td>

            <td style="max-width:160px;font-size:.83rem;color:#374151;">
              <?= $facAnio ?>
            </td>

            <td>
              <span class="badge-metodo <?= $clase ?>"><?= $mp ?></span>
            </td>

            <td>
              <?php if ($esImagen && file_exists($rutaFisica)): ?>
                <img src="<?= htmlspecialchars($rutaWeb) ?>"
                     class="thumb-comp"
                     data-bs-toggle="modal"
                     data-bs-target="#modalComp"
                     data-src="<?= htmlspecialchars($rutaWeb) ?>"
                     data-nombre="<?= htmlspecialchars(
                       trim(($f['nombre'] ?? '') . ' ' . ($f['apellido'] ?? ''))
                     ) ?>"
                     alt="Comprobante">
              <?php elseif ($esPdf && file_exists($rutaFisica)): ?>
                <a href="<?= htmlspecialchars($rutaWeb) ?>" target="_blank"
                   class="badge-metodo badge-ach text-decoration-none">
                  <i class="bi bi-file-earmark-pdf me-1"></i>Ver PDF
                </a>
              <?php else: ?>
                <span class="no-comp">–</span>
              <?php endif; ?>
            </td>

            <td style="font-size:.82rem;color:#6b7280;white-space:nowrap;">
              <?= date('d/m/Y H:i', strtotime($f['fecha_registro'])) ?>
            </td>
          </tr>
          <?php endwhile; else: ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-5">
              <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
              No hay inscripciones registradas todav铆a.
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- MODAL COMPROBANTE -->
<div class="modal fade" id="modalComp" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius:18px;overflow:hidden;">
      <div class="modal-header"
           style="background:#5B0FA6;color:#fff;border:none;padding:1rem 1.5rem;">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-image me-2"></i>
          Comprobante — <span id="modalNombre"></span>
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-3 text-center" style="background:#111827;">
        <img id="modalImg" src="" class="modal-comp-img" alt="Comprobante de pago">
      </div>
      <div class="modal-footer" style="border:none;padding:.8rem 1.2rem;">
        <a id="modalDescarga" href="#" download
           style="background:#5B0FA6;color:#fff;border-radius:8px;
                  padding:6px 18px;font-weight:700;font-size:.88rem;
                  text-decoration:none;">
          <i class="bi bi-download me-1"></i>Descargar
        </a>
        <button type="button" class="btn btn-sm btn-light"
                data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* Modal: carga imagen y nombre */
document.getElementById('modalComp').addEventListener('show.bs.modal', function(e) {
  var t = e.relatedTarget;
  document.getElementById('modalImg').src              = t.dataset.src;
  document.getElementById('modalNombre').textContent   = t.dataset.nombre;
  document.getElementById('modalDescarga').href        = t.dataset.src;
});

/* Buscador en tiempo real */
document.getElementById('buscador').addEventListener('input', function() {
  var q   = this.value.toLowerCase();
  var rows = document.querySelectorAll('#tablaInscritos tbody tr');
  var vis  = 0;
  rows.forEach(function(row) {
    var show = row.textContent.toLowerCase().includes(q);
    row.style.display = show ? '' : 'none';
    if (show) vis++;
  });
  document.getElementById('contadorVisible').textContent = vis;
});
</script>
</body>
</html>
