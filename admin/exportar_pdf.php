                                                                                                      <?php
/* =====================================================
   exportar_pdf.php — Congreso UTP
   Genera PDF con: nombre, apellido, cédula,
   tipo participante, método de pago, fecha
   e imagen del comprobante cuando existe.
   ===================================================== */

/* ── Protección de sesión ── */
include("auth.php");
include("../includes/config.php");
require("../fpdf/fpdf.php");


$conn->set_charset("utf8mb4"); 

/* ─────────────────────────────────────────────
   Clase PDF personalizada con cabecera y pie
   ───────────────────────────────────────────── */
class PDFCongreso extends FPDF
{
    function Header()
    {
        /* Fondo morado en la cabecera */
        $this->SetFillColor(62, 10, 117);
        $this->Rect(0, 0, 210, 28, 'F');

        /* Título */
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(255, 255, 255);
        $this->SetY(8);
        $this->Cell(0, 8, 'Lista de Inscritos - IV Congreso Internacional', 0, 1, 'C');

        /* Subtítulo con fecha */
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(220, 210, 240);
        $this->Cell(0, 6, 'Generado el: ' . date('d/m/Y H:i:s'), 0, 1, 'C');

        /* Espacio después de cabecera */
        $this->Ln(6);
        $this->SetTextColor(0, 0, 0);
    }

    function Footer()
    {
        $this->SetY(-14);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10,
            'Pagina ' . $this->PageNo() . ' / {nb}  - IV Congreso Internacional',
            0, 0, 'C'
        );
    }
}

/* ─────────────────────────────────────────────
   Consulta a la base de datos
   ───────────────────────────────────────────── */
$sql = "SELECT * FROM inscripciones ORDER BY fecha_registro DESC";
$res = $conn->query($sql);

if (!$res) {
    die("Error en la consulta: " . $conn->error);
}

/* ─────────────────────────────────────────────
   Crear el PDF
   ───────────────────────────────────────────── */
$pdf = new PDFCongreso('L', 'mm', 'A4'); 
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

/* ── Encabezado de tabla ── */
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(248, 245, 255);
$pdf->SetDrawColor(180, 160, 220);
$pdf->SetTextColor(62, 10, 117);
$pdf->SetLineWidth(0.3);

/* Anchos de columna (total ~277mm en A4 landscape) */
$cols = [
    '#'               => 10,
    'Nombre'          => 55,
    'Cedula'          => 28,
    'Tipo'            => 30,
    'Facultad/Anio'   => 55,
    'Metodo Pago'     => 28,
    'Fecha'           => 36,
    'Comprobante'     => 35,
];

foreach ($cols as $label => $w) {
    $pdf->Cell($w, 9, $label, 1, 0, 'C', true);
}
$pdf->Ln();

/* ── Filas de datos ── */
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);

$fill = false; /* Alterna color de fila */
$num  = 1;

while ($f = $res->fetch_assoc()) {

    $nombre     = utf8_decode(trim(($f['nombre'] ?? '') . ' ' . ($f['apellido'] ?? '')));
    $cedula     = $f['cedula'] ?? '–';
    $tipo       = utf8_decode($f['tipo_participante'] ?? '–');
    $facAnio    = utf8_decode($f['facultad'] ?? '–');
    if (!empty($f['anio'])) $facAnio .= ' ' . $f['anio'];
    $pago       = utf8_decode($f['metodo_pago'] ?? '–');
    $fecha      = date('d/m/Y H:i', strtotime($f['fecha_registro']));
    $comp       = $f['comprobante'] ?? '';
    $rutaFisica = '../' . $comp;
    $ext        = strtolower(pathinfo($comp, PATHINFO_EXTENSION));
    $esImagen   = in_array($ext, ['jpg','jpeg','png']) && !empty($comp) && file_exists($rutaFisica);

    /* Color de fondo alternado */
    $bgR = $fill ? 250 : 255;
    $bgG = $fill ? 247 : 255;
    $bgB = $fill ? 255 : 255;
    $pdf->SetFillColor($bgR, $bgG, $bgB);

    /* Si hay imagen de comprobante la fila necesita más alto */
    $rowH = $esImagen ? 22 : 9;

    /* Guardar posición Y antes de la fila */
    $y0 = $pdf->GetY();
    $x0 = $pdf->GetX();

    /* Salto de página automático si queda poco espacio */
    if ($y0 + $rowH > $pdf->GetPageHeight() - 25) {
        $pdf->AddPage();
        /* Repetir encabezado de tabla */
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(248, 245, 255);
        $pdf->SetTextColor(62, 10, 117);
        foreach ($cols as $label => $w) {
            $pdf->Cell($w, 9, $label, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor($bgR, $bgG, $bgB);
        $y0 = $pdf->GetY();
    }

    /* Dibujar celdas */
    $pdf->Cell($cols['#'],               $rowH, $num++,   1, 0, 'C', true);
    $pdf->Cell($cols['Nombre'],          $rowH, $nombre,  1, 0, 'L', true);
    $pdf->Cell($cols['Cedula'],          $rowH, $cedula,  1, 0, 'C', true);
    $pdf->Cell($cols['Tipo'],            $rowH, $tipo,    1, 0, 'C', true);
    $pdf->Cell($cols['Facultad/Anio'],   $rowH, $facAnio, 1, 0, 'L', true);
    $pdf->Cell($cols['Metodo Pago'],     $rowH, $pago,    1, 0, 'C', true);
    $pdf->Cell($cols['Fecha'],           $rowH, $fecha,   1, 0, 'C', true);

    /* Celda comprobante */
    $xComp = $pdf->GetX();
    $yComp = $pdf->GetY();
    $pdf->Cell($cols['Comprobante'], $rowH, $esImagen ? '' : 'Sin comp.', 1, 0, 'C', true);
    $pdf->Ln();

    /* Insertar miniatura de comprobante si existe */
    if ($esImagen) {
        /* Imagen centrada dentro de la celda de comprobante */
        $imgW = 18; /* mm */
        $imgX = $xComp + ($cols['Comprobante'] - $imgW) / 2;
        $imgY = $yComp + ($rowH - 18) / 2;
        try {
            $pdf->Image($rutaFisica, $imgX, $imgY, $imgW, 18);
        } catch (Exception $e) {
            /* Si la imagen falla, no bloquea el PDF */
        }
    }

    $fill = !$fill;
}

/* Totales al pie de la tabla */
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(62, 10, 117);
$pdf->SetTextColor(255, 255, 255);
$total    = $conn->query("SELECT COUNT(*) AS n FROM inscripciones")->fetch_assoc()['n'];
$ach      = $conn->query("SELECT COUNT(*) AS n FROM inscripciones WHERE metodo_pago='ACH'")->fetch_assoc()['n'];
$efectivo = $conn->query("SELECT COUNT(*) AS n FROM inscripciones WHERE metodo_pago='Efectivo'")->fetch_assoc()['n'];
$exento   = $conn->query("SELECT COUNT(*) AS n FROM inscripciones WHERE metodo_pago='Exento'")->fetch_assoc()['n'];

$pdf->Cell(60, 8, 'Total inscritos: ' . $total,    1, 0, 'C', true);
$pdf->Cell(60, 8, 'ACH: ' . $ach,                  1, 0, 'C', true);
$pdf->Cell(60, 8, 'Efectivo: ' . $efectivo,        1, 0, 'C', true);
$pdf->Cell(60, 8, 'Exentos: ' . $exento,           1, 0, 'C', true);
$pdf->Ln();

/* ── Enviar PDF al navegador (descarga directa) ── */
$pdf->Output('D', 'inscritos_congreso_' . date('Ymd_His') . '.pdf');
exit;


