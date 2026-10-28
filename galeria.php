<?php
// Ocultar cabecera X-Powered-By
header_remove("X-Powered-By");

header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
?>

<?php include("includes/header.php"); ?>
<div style="width:100%; border-radius: 0 0 40px 40px; overflow:hidden; background: linear-gradient(135deg, #F2F2F2 0%, #666666 45%, #333333 100%); padding: 70px 40px 60px; position:relative; box-sizing:border-box; margin-top: 80px;">
  <div style="position:absolute; top:0; left:0; width:100%; height:100%; overflow:hidden; pointer-events:none;">
    <div style="position:absolute; top:-60px; right:-60px; width:280px; height:280px; border-radius:50%; background:rgba(255,255,255,0.05);"></div>
    <div style="position:absolute; bottom:-80px; left:-40px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
    <div style="position:absolute; top:30px; left:50%; width:1px; height:calc(100% - 60px); background:rgba(255,255,255,0.08);"></div>
  </div>
  <div style="position:relative; z-index:2; max-width:700px; margin:0 auto; text-align:center;">
    <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:999px; padding:6px 16px; margin-bottom:20px;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
      <span style="font-size:12px; color:rgba(255,255,255,0.85); font-weight:500; letter-spacing:0.06em; text-transform:uppercase;">Memorias del Congreso · UTP Colón</span>
    </div>
    <h1 style="font-size:clamp(2rem, 5vw, 3rem); font-weight:800; color:#fff; margin:0 0 12px; line-height:1.1; letter-spacing:-0.5px;">
      Galería 2024
    </h1>
    <p style="font-size:clamp(0.95rem, 2vw, 1.1rem); color:rgba(255,255,255,0.8); margin:0 auto; max-width:520px; line-height:1.6;">
      Un recorrido visual por algunos de los momentos más destacados del congreso.
    </p>
  </div>
  <div style="position:absolute; bottom:0; left:0; width:100%; height:4px; background:linear-gradient(90deg, #E8E8E8, rgba(232,232,232,0.3), #E8E8E8);"></div>
</div>

<!-- GALERÍA -->
<section class="galeria-section">
  <div class="container">
    <div class="row g-4 align-items-stretch">

      <!-- Acto institucional (autoridades) -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/autoridades.jpeg" alt="Acto de apertura" class="galeria-img">
          </div>
           <div class="galeria-overlay">
            <h5>Acto Institucional</h5>
            <p>Apertura oficial del congreso con autoridades e invitados especiales.</p>
          </div>
        </div>
      </div>

      <!--  Oradora en podio UTP -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/podio.jpeg" alt="Palabras de apertura" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Palabras de Bienvenida</h5>
            <p>Discurso de apertura desde el podio institucional de la UTP.</p>
          </div>
        </div>
      </div>

      <!-- Baile folklórico -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/apertura2.jpeg" alt="Acto cultural folklórico" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Acto Cultural</h5>
            <p>Presentación de baile folklórico panameño durante la ceremonia de apertura.</p>
          </div>
        </div>
      </div>

      <!--  Conferencia geopolítica (PLIMP) -->
      <div class="col-md-6 col-lg-4">  
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/dia1.jpeg" alt="Conferencia magistral" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Conferencia Magistral</h5>
            <p>Ponencia sobre geopolítica mundial y seguridad marítima internacional.</p>
          </div>
        </div>
      </div>

      <!-- Presentación HUBS economía regional -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/conferencia.jpeg" alt="Presentación académica HUBS" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Participación Académica</h5>
            <p>Exposición sobre la importancia de los HUBS en la economía regional.</p>
          </div>
        </div>
      </div>

      <!-- Presentación CSIRT  -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/dia2.jpeg" alt="Conferencia CSIRT Panamá" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Innovación y Tecnología</h5>
            <p>Conferencia del CSIRT Panamá sobre ciberseguridad ante un auditorio lleno.</p>
          </div>
        </div>
      </div>

      <!--  Foto grupal autoridades/ponentes -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/asistentes.jpeg" alt="Foto grupal ponentes y autoridades" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Asistentes y Delegaciones</h5>
            <p>Foto oficial con ponentes, docentes y autoridades del congreso 2025.</p>
          </div>
        </div>
      </div>

      <!--  Gira académica (fuerte histórico) -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/gira1.jpeg" alt="Gira académica sitio histórico" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Gira Académica</h5>
            <p>Visita al sitio histórico como parte de las actividades complementarias del congreso.</p>
          </div>
        </div>
      </div>

      <!--  Gira (grupo bajo techo) -->
      <div class="col-md-6 col-lg-4">
        <div class="galeria-card">
            <div class="galeria-img-wrapper">
          <img src="assets/img/galeria/gira2.jpeg" alt="Gira académica - recorrido" class="galeria-img">
           </div>
           <div class="galeria-overlay">
            <h5>Momentos Destacados</h5>
            <p>Participantes durante el recorrido de la gira académica complementaria.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include("includes/footer.php"); ?>
