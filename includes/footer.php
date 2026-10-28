<?php
// Ocultar cabecera X-Powered-By
header_remove("X-Powered-By");

// Si no lo haces via .htaccess, puedes agregar headers aqu�� tambi��n:
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Importar Rokkitt desde Google Fonts (agrega esto) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rokkitt:wght@400;600;700;800&display=swap" rel="stylesheet">
  
  <title>CINET COLON</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<!-- NAVEGACI�0�7N -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid px-5">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
      <img src="assets/img/utp45.png" width="45" class="me-2">
    </a>

    <!-- BOT�0�7N HAMBURGUESA cerrado correctamente con span adentro -->
    <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuNav"
            aria-controls="menuNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MEN�0�3 fuera del button, al mismo nivel -->
    <div class="collapse navbar-collapse justify-content-end" id="menuNav">
      <ul class="navbar-nav gap-3">
        <li><a class="nav-link" href="index.php">Inicio</a></li>
        <li><a class="nav-link" href="cronograma.php">Cronograma</a></li>
        <li><a class="nav-link" href="inscripcion.php">Inscripción</a></li>
        <li><a class="nav-link" href="galeria.php">Galería</a></li>
      </ul>
    </div>

  </div>
</nav>

<!-- Script: link activo seg��n p��gina actual -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname.split("/").pop();
    document.querySelectorAll(".nav-link").forEach(link => {
      if (link.getAttribute("href") === currentPage) {
        link.classList.add("active");
      }
    });
  });
</script>

<!-- Script: navbar compacta al hacer scroll -->
<script>
  window.addEventListener("scroll", function () {
    document.querySelector(".navbar")
      .classList.toggle("scrolled", window.scrollY > 50);
  });
</script>

<!-- Script: animaciones reveal al hacer scroll -->
<script>
  window.addEventListener("scroll", function () {
    document.querySelectorAll(".reveal").forEach(el => {
      if (el.getBoundingClientRect().top < window.innerHeight - 100) {
        el.classList.add("active");
      }
    });
  });
</script>

<!-- Bootstrap JS (debe ir primero) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toggle manual: respaldo para Android/Samsung antiguos -->
<script>
  document.addEventListener("DOMContentLoaded", function () {

    var toggler = document.querySelector(".navbar-toggler");
    var menu    = document.getElementById("menuNav");

    if (!toggler || !menu) return;

    /* Respaldo: si Bootstrap no activ�� el collapse, lo hacemos a mano */
    toggler.addEventListener("click", function (e) {
      e.stopPropagation();

      var isOpen = menu.classList.contains("show");

      if (isOpen) {
        menu.classList.remove("show");
        menu.classList.add("collapsing");
        setTimeout(function () {
          menu.classList.remove("collapsing");
          menu.style.height = "";
        }, 300);
        toggler.setAttribute("aria-expanded", "false");
      } else {
        menu.classList.add("show");
        toggler.setAttribute("aria-expanded", "true");
      }
    });

    /* Cierra el men�� al tocar fuera */
    document.addEventListener("click", function (e) {
      if (!toggler.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove("show");
        toggler.setAttribute("aria-expanded", "false");
      }
    });

    /* Cierra el men�� al tocar un link */
    menu.querySelectorAll(".nav-link").forEach(function (link) {
      link.addEventListener("click", function () {
        menu.classList.remove("show");
        toggler.setAttribute("aria-expanded", "false");
      });
    });

  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
