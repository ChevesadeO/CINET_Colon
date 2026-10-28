<?php
// footer global para incluir en todas las páginas
?>

<footer class="site-footer bg-dark text-light pt-5 pb-3 mt-0">
  <div class="container">

    <div class="row align-items-start gy-4">

      <!-- Bloque izquierdo -->
      <div class="col-lg-8">
        <div class="d-flex align-items-start gap-4 flex-column flex-md-row">

          <!-- Logo -->
          <div class="footer-logo">
            <img src="img/logo-utp-blanco.png" alt="Logo UTP" class="img-fluid" style="max-width: 90px;">
          </div>

          <!-- Información -->
          <div class="footer-info">
            <p class="mb-1 fw-semibold">Universidad Tecnológica de Panamá - 2026</p>
            <p class="mb-1">Dirección: Antiguo Fuerte Davis, provincia de Colón, República de Panamá.</p>
            <p class="mb-1">Teléfono: (507) 475-3302 / 475-4617 / 475-4615 / 475-4619</p>
            <p class="mb-0">Correo electrónico: info@cinetcolon.com</p>
          </div>

        </div>
      </div>

      <!-- Bloque derecho -->
      <div class="col-lg-4">
        <div class="row">
          <div class="col-6">
        

          <div class="col-6 border-start border-secondary ps-4">
            <ul class="list-unstyled footer-links mb-0">
              <li><a href="index.php" class="text-light text-decoration-none">Inicio</a></li>
              <li><a href="cronograma.php" class="text-light text-decoration-none">Cronograma</a></li>
              <li><a href="inscripcion.php" class="text-light text-decoration-none">Inscripcion</a></li>
              <li><a href="galeria.php" class="text-light text-decoration-none">Galeria</a></li>
              <li><a href="admin\inscritos.php" class="text-light text-decoration-none">Login</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Parte inferior -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top border-secondary">

      <div class="text-white-50 small mb-3 mb-md-0">
        © <?php echo date("Y"); ?> IV Congreso Internacional
      </div>

      <div class="d-flex gap-3">
        <a href="https://www.facebook.com/paginautp" class="text-light fs-5"><i class="bi bi-facebook"></i></a>
        <a href="https://x.com/utppanama" class="text-light fs-5"><i class="bi bi-twitter"></i></a>
        <a href="https://www.youtube.com/user/UTPPanama" class="text-light fs-5"><i class="bi bi-youtube"></i></a>
        <a href="https://www.instagram.com/utppanama" class="text-light fs-5"><i class="bi bi-instagram"></i></a>
      </div>

    </div>

  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS propio -->
<script src="assets/js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>


