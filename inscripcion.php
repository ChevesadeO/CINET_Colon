<?php
// Ocultar cabecera X-Powered-By
header_remove("X-Powered-By");

header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
?>

<?php
include("includes/config.php");
include("includes/header.php");

$mensaje = "";
$nombre_usuario = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $cedula = trim($_POST["cedula"] ?? "");
    $tipo_participante = trim($_POST["tipo_participante"] ?? "");
    $facultad = trim($_POST["facultad"] ?? "");
    $anio = trim($_POST["anio"] ?? "");
    $metodo_pago = trim($_POST["metodo_pago"] ?? "");
    $comprobante = "";

    if (empty($nombre) || empty($apellido) || empty($cedula) || empty($tipo_participante) || empty($metodo_pago)) {
        $mensaje = "campos_vacios";
    } else {

        if ($tipo_participante === "Estudiante" || $tipo_participante === "Docente") {
            if (empty($facultad)) {
                $mensaje = "facultad_invalida";
            }
        } else {
            $facultad = NULL;
        }

        if ($tipo_participante !== "Estudiante") {
            $anio = NULL;
        } else {
            $anios_validos = ["1°", "2°", "3°", "4°", "5°"];
            if (!in_array($anio, $anios_validos)) {
                $mensaje = "anio_invalido";
            }
        }

        if (empty($mensaje)) {
            if ($metodo_pago === "ACH") {
                if (!isset($_FILES["slip"]) || $_FILES["slip"]["error"] !== 0) {
                    $mensaje = "slip_requerido";
                } else {
                    $permitidos = ["jpg", "jpeg", "png", "pdf"];
                    $nombreArchivo = $_FILES["slip"]["name"];
                    $archivoTmp = $_FILES["slip"]["tmp_name"];
                    $tamanoArchivo = $_FILES["slip"]["size"];
                    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

                    if (!in_array($extension, $permitidos)) {
                        $mensaje = "slip_invalido";
                    } elseif ($tamanoArchivo > 5 * 1024 * 1024) {
                        $mensaje = "slip_pesado";
                    } else {
                        $carpetaDestino = "uploads/";

                        if (!is_dir($carpetaDestino)) {
                            mkdir($carpetaDestino, 0777, true);
                        }

                        $nombreSeguro = preg_replace('/[^A-Za-z0-9_\-]/', '_', $cedula);
                        $nuevoNombre = "slip_" . $nombreSeguro . "_" . time() . "." . $extension;
                        $rutaDestino = $carpetaDestino . $nuevoNombre;

                        if (move_uploaded_file($archivoTmp, $rutaDestino)) {
                            $comprobante = $rutaDestino;
                        } else {
                            $mensaje = "error_subida";
                        }
                    }
                }
            } else {
                $comprobante = NULL;
            }
        }

        if (empty($mensaje)) {

            $sql = "INSERT INTO inscripciones 
                    (nombre, apellido, cedula, tipo_participante, facultad, anio, comprobante, metodo_pago)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssssssss", $nombre, $apellido, $cedula, $tipo_participante, $facultad, $anio, $comprobante, $metodo_pago);

                if ($stmt->execute()) {
                    $mensaje = "success";
                    $nombre_usuario = $nombre . " " . $apellido;
                } else {
                    $mensaje = "error_bd";
                }

                $stmt->close();
            } else {
                $mensaje = "error_sql";
            }
        }
    }
}
?>

<!-- BANNER INSCRIPCIÓN -->
<div class="banner-congreso banner-congreso--inscripcion">

  <div class="banner-congreso__decoracion" aria-hidden="true">
    <div class="banner-congreso__circulo banner-congreso__circulo--top"></div>
    <div class="banner-congreso__circulo banner-congreso__circulo--bottom"></div>
    <div class="banner-congreso__linea"></div>
  </div>

  <div class="banner-congreso__contenido">

    <div class="banner-congreso__badge">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      <span>4to Congreso Internacional · UTP Colón</span>
    </div>

    <h1 class="banner-congreso__titulo">Formulario de Inscripción</h1>
    <h4 class="banner-congreso__subtitulo">Costos</h4>

    <div class="banner-congreso__costos">
      <div class="banner-congreso__costo-item">
        <span class="banner-congreso__costo-label">Estudiantes</span>
        <span class="banner-congreso__costo-precio">$10.00</span>
      </div>
      <div class="banner-congreso__separador" aria-hidden="true"></div>
      <div class="banner-congreso__costo-item">
        <span class="banner-congreso__costo-label">Profesores</span>
        <span class="banner-congreso__costo-precio">$15.00</span>
      </div>
      <div class="banner-congreso__separador" aria-hidden="true"></div>
      <div class="banner-congreso__costo-item">
        <span class="banner-congreso__costo-label">Público general</span>
        <span class="banner-congreso__costo-precio">$25.00</span>
      </div>
    </div>

  </div>

  <div class="banner-congreso__linea-inferior" aria-hidden="true"></div>
</div>

<!-- FORMULARIO -->
<section class="form-section">
  <div class="container">
    <div id="inscripcionLayout" class="inscripcion-layout">
      <form method="POST" id="formInscripcion" enctype="multipart/form-data">
        <div class="row g-4 align-items-stretch justify-content-center flex-nowrap" id="layoutRow">

          <!-- FORMULARIO -->
          <div class="col-formulario">
            <div class="card form-card border-0 p-5 mx-auto fade-up h-100">

              <div class="mb-4">
                <label class="form-label fw-semibold">Nombre</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                  <input type="text" name="nombre" class="form-control" required>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Apellido</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                  <input type="text" name="apellido" class="form-control" required>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Cédula</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                  <input type="text" name="cedula" class="form-control" required>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Tipo de participante</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                  <select name="tipo_participante" id="tipo_participante" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    <option value="Estudiante">Estudiante</option>
                    <option value="Docente">Docente</option>
                    <option value="Publico en general">Público en general</option>
                  </select>
                </div>
              </div>

              <div class="mb-4" id="campo_facultad" style="display:none;">
                <label class="form-label fw-semibold">Facultad</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-building"></i></span>
                  <select name="facultad" id="facultad" class="form-select">
                    <option value="">-- Selecciona --</option>
                    <option value="Facultad de Ingeniería de Sistemas Computacionales">Facultad de Ingeniería de Sistemas Computacionales</option>
                    <option value="Facultad de Ingeniería Civil">Facultad de Ingeniería Civil</option>
                    <option value="Facultad de Ingeniería Eléctrica">Facultad de Ingeniería Eléctrica</option>
                    <option value="Facultad de Ingeniería Industrial">Facultad de Ingeniería Industrial</option>
                    <option value="Facultad de Ingeniería Mecánica">Facultad de Ingeniería Mecánica</option>
                    <option value="Facultad de Ciencia y Tecnología">Facultad de Ciencia y Tecnología</option>
                    <option value="Centro Regional de Colón">Centro Regional de Colón</option>
                  </select>
                </div>
              </div>

              <div class="mb-4" id="campo_anio" style="display:none;">
                <label class="form-label fw-semibold">Año que cursa</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-bar-chart-fill"></i></span>
                  <select name="anio" id="anio" class="form-select">
                    <option value="">-- Selecciona --</option>
                    <option value="1°">1° año</option>
                    <option value="2°">2° año</option>
                    <option value="3°">3° año</option>
                    <option value="4°">4° año</option>
                    <option value="5°">5° año</option>
                  </select>
                </div>
              </div>

              <div class="mb-3" id="campo_metodo_pago">
                <label class="form-label fw-semibold">Opciones de pago</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                  <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    <option value="ACH">ACH</option>
                    <option value="Ventanilla">Pago por ventanilla en el centro</option>
                  </select>
                </div>
              </div>

              <div id="mensaje_pago" class="mb-3" style="display:none;"></div>

              <div id="bloque_slip" style="display:none;">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Adjuntar slip o comprobante</label>
                  <div class="custom-file-upload">
                    <input type="file" name="slip" id="slip" class="d-none" accept=".jpg,.jpeg,.png,.pdf">
                    <label for="slip" class="file-upload-box">
                      <span class="file-upload-icon">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                      </span>
                      <span class="file-upload-text">
                        Haz clic para seleccionar tu comprobante
                      </span>
                      <span class="file-upload-name" id="fileName">
                        Ningún archivo seleccionado
                      </span>
                    </label>
                  </div>
                  <small class="text-muted d-block mt-2">
                    Formatos permitidos: JPG, JPEG, PNG, PDF. Máximo 5MB.
                  </small>
                </div>
              </div>

              <div class="form-action">
                <button type="submit" id="btnEnviar" class="btn btn-success fw-bold">
                  Completar inscripción
                </button>
              </div>

            </div>
          </div>

          <!-- INFORMACIÓN DE PAGO -->
          <div class="col-pago" id="columna_pago">
            <div class="card payment-card border-0 p-5 h-100 shadow-sm fade-up d-flex flex-column">
              <h4 class="fw-bold mb-4">Información de Pago por ACH</h4>
              <div class="mb-3">
                  <p class="mb-2"><strong>Banco Nacional de Panamá</strong></p>
                <p class="mb-2"><strong>Beneficiario:</strong> Fundación Tecnológica de Panamá</p>
                <p class="mb-2"><strong>Tipo de cuenta:</strong> Corriente</p>
                <p class="mb-0"><strong># de cuenta:</strong> 010000032630</p>
              </div>
              <div class="alert alert-light border mt-3 mb-0">
                <strong>Mensaje importante:</strong><br>
                En el slip colocar:
                <ul class="mb-0 mt-2 ps-3">
                  <li>Nombre completo del propietario de la cuenta</li>
                  <li># de cédula del participante</li>
                  <li>4° Congreso</li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("formInscripcion").addEventListener("submit", function () {
    Swal.fire({
        title: 'Procesando inscripción...',
        html: 'Estamos registrando tus datos <br><b>No cierres esta ventana</b>',
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const tipo = document.getElementById("tipo_participante");
    const campoFacultad = document.getElementById("campo_facultad");
    const facultad = document.getElementById("facultad");
    const campoAnio = document.getElementById("campo_anio");
    const anio = document.getElementById("anio");

    const metodoPago = document.getElementById("metodo_pago");
    const bloqueSlip = document.getElementById("bloque_slip");
    const slip = document.getElementById("slip");
    const fileName = document.getElementById("fileName");
    const mensajePago = document.getElementById("mensaje_pago");
    const columnaPago = document.getElementById("columna_pago");
    const layout = document.getElementById("inscripcionLayout");

    function toggleFormulario() {
        if (tipo.value === "Estudiante") {
            campoFacultad.style.display = "block";
            facultad.setAttribute("required", "required");
            campoAnio.style.display = "block";
            anio.setAttribute("required", "required");
        } else if (tipo.value === "Docente") {
            campoFacultad.style.display = "block";
            facultad.setAttribute("required", "required");
            campoAnio.style.display = "none";
            anio.removeAttribute("required");
            anio.value = "";
        } else {
            campoFacultad.style.display = "none";
            facultad.removeAttribute("required");
            facultad.value = "";
            campoAnio.style.display = "none";
            anio.removeAttribute("required");
            anio.value = "";
        }
    }

    function togglePago() {
        if (metodoPago.value === "ACH") {
            bloqueSlip.style.display = "block";
            slip.setAttribute("required", "required");
            layout.classList.add("split-mode");
            mensajePago.style.display = "block";
            mensajePago.className = "alert alert-info mb-3";
            mensajePago.textContent = "Has seleccionado ACH, por favor sube el comprobante";
        } else if (metodoPago.value === "Ventanilla") {
            bloqueSlip.style.display = "none";
            slip.removeAttribute("required");
            slip.value = "";
            fileName.textContent = "Ningún archivo seleccionado";
            layout.classList.remove("split-mode");
            mensajePago.style.display = "block";
            mensajePago.className = "alert alert-success mb-3";
            mensajePago.textContent = "Has seleccionado pago por ventanilla, puedes realizar el pago en la subdirección administrativa, edificio 235 primer alto.";
        } else {
            bloqueSlip.style.display = "none";
            slip.removeAttribute("required");
            slip.value = "";
            fileName.textContent = "Ningún archivo seleccionado";
            layout.classList.remove("split-mode");
            mensajePago.style.display = "none";
            mensajePago.textContent = "";
        }
    }

    tipo.addEventListener("change", toggleFormulario);
    metodoPago.addEventListener("change", togglePago);

    if (slip && fileName) {
        slip.addEventListener("change", function () {
            if (this.files && this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            } else {
                fileName.textContent = "Ningún archivo seleccionado";
            }
        });
    }

    toggleFormulario();
    togglePago();
});
</script>

<?php if ($mensaje === "success"): ?>
<script>
Swal.fire({
    icon: 'success',
    title: '¡Inscripción exitosa!',
    text: 'Registro completado correctamente para <?php echo addslashes($nombre_usuario); ?>.',
    confirmButtonColor: '#198754',
    confirmButtonText: 'Aceptar',
    allowOutsideClick: false
}).then(() => {
    window.location.href = "inscripcion.php";
});
</script>
<?php elseif ($mensaje === "campos_vacios"): ?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Campos incompletos',
    text: 'Debes completar todos los campos obligatorios.',
    confirmButtonColor: '#f0ad4e',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "facultad_invalida"): ?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Facultad no seleccionada',
    text: 'Si eres estudiante o docente, debes seleccionar una facultad.',
    confirmButtonColor: '#f0ad4e',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "anio_invalido"): ?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Año no seleccionado',
    text: 'Si eres estudiante, debes seleccionar el año que cursas.',
    confirmButtonColor: '#f0ad4e',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "slip_requerido"): ?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Comprobante requerido',
    text: 'Has seleccionado ACH, por favor sube el comprobante.',
    confirmButtonColor: '#f0ad4e',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "slip_invalido"): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Formato no permitido',
    text: 'Solo se aceptan archivos JPG, JPEG, PNG o PDF.',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "slip_pesado"): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Archivo demasiado grande',
    text: 'El comprobante no debe superar los 5MB.',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "error_subida"): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error al subir archivo',
    text: 'No se pudo guardar el comprobante en el servidor.',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "error_bd"): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error al guardar',
    text: 'Ocurrió un problema al registrar la inscripción en la base de datos.',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Aceptar'
});
</script>
<?php elseif ($mensaje === "error_sql"): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error interno',
    text: 'No se pudo preparar la consulta SQL.',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<?php include("includes/footer.php"); ?>

