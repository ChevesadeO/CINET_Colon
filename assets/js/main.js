/* ===== PARTICULAS OSCURO 
tsParticles.load("particles", {
  background: { color: "transparent" },
  particles: {
    number: { value: 50 },
    size: { value: 3 },
    color: { value: "#3E0A75" },
    opacity: { value: 0.20 },
    move: {
      enable: true,
      speed: 0.9
    }
  }
}); ===== */

/* ===== EFECTO MOUSE OSCURO ===== */
const hero = document.querySelector(".hero-elegante");

if (hero) {
  hero.addEventListener("mousemove", e => {
    const rect = hero.getBoundingClientRect();
    hero.style.setProperty("--x", `${e.clientX - rect.left}px`);
    hero.style.setProperty("--y", `${e.clientY - rect.top}px`);
  });
}

/* ===== PARTICULAS CLARO 
tsParticles.load("particles-light", {
  background: { color: "transparent" },
  particles: {
    number: { value: 50 },
    size: { value: 3 },
    color: { value: "#5B0FA6" }, // 
    opacity: { value: 0.18 },
    move: {
      enable: true,
      speed: 0.9
    }
  }
}); ===== */

/* ===== EFECTO MOUSE CLARO ===== */
const heroClaro = document.querySelector(".hero-claro");

if (heroClaro) {
  heroClaro.addEventListener("mousemove", e => {
    const rect = heroClaro.getBoundingClientRect();
    heroClaro.style.setProperty("--x", `${e.clientX - rect.left}px`);
    heroClaro.style.setProperty("--y", `${e.clientY - rect.top}px`);
  });
}

/* ===== CAMBIO AUTOMATICO DIA/NOCHE ===== */
document.addEventListener("DOMContentLoaded", function() {

  const hora = new Date().getHours();
  const hero = document.getElementById("hero");

  if (hero) {
    if (hora >= 6 && hora < 19) {
      hero.classList.add("hero-claro");
      hero.classList.remove("hero-oscuro");
    } else {
      hero.classList.add("hero-elegante");
      hero.classList.remove("hero-claro");
    }
  }

});

/* ===== MODO BODY ===== */
document.addEventListener("DOMContentLoaded", function() {

  const hora = new Date().getHours();
  const body = document.body;

  if (hora >= 6 && hora < 19) {
    body.classList.add("modo-claro");
  } else {
    body.classList.add("modo-oscuro");
  }

  setTimeout(() => {
    body.classList.add("visible");
  }, 100);

});


document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".hero-slide");
  let current = 0;

  if (slides.length > 0) {
    setInterval(() => {
      slides[current].classList.remove("active");
      current = (current + 1) % slides.length;
      slides[current].classList.add("active");
    }, 4500); // cambia cada 4.5 segundos
  }
});

// ===== MODAL CONFERENCIAS Y EXPOSITORES =====

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".conferencia-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      Swal.fire({
        title: this.dataset.titulo,
        html: `
          <p><strong>Facultad:</strong> ${this.dataset.facultad}</p>
          <p><strong>Hora:</strong> ${this.dataset.hora}</p>
          <p><strong>Sal車n:</strong> ${this.dataset.salon}</p>
          <hr>
          <p>${this.dataset.resumen}</p>
        `,
        icon: "info",
        confirmButtonText: "Cerrar",
        confirmButtonColor: "#5B0FA6"
      });
    });
  });

  document.querySelectorAll(".expositor-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      Swal.fire({
        title: this.dataset.nombre,
        html: `
          <p><strong>Cargo:</strong> ${this.dataset.cargo}</p>
          <p><strong>Instituci車n:</strong> ${this.dataset.institucion}</p>
          <hr>
          <p>${this.dataset.bio}</p>
        `,
        icon: "question",
        confirmButtonText: "Cerrar",
        confirmButtonColor: "#5B0FA6"
      });
    });
  });
});




// CRONOGRAMA POPUPS
document.addEventListener("DOMContentLoaded", function () {

  document.querySelectorAll(".conferencia-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      Swal.fire({
        title: this.dataset.titulo,
        html: `
          <p><strong>Facultad:</strong> ${this.dataset.facultad}</p>
          <p><strong>Hora:</strong> ${this.dataset.hora}</p>
          <p><strong>Sal車n:</strong> ${this.dataset.salon}</p>
          <hr>
          <p>${this.dataset.resumen}</p>
        `,
        icon: "info",
        confirmButtonColor: "#5B0FA6"
      });
    });
  });

  document.querySelectorAll(".expositor-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      Swal.fire({
        title: this.dataset.nombre,
        html: `
          <p><strong>Cargo:</strong> ${this.dataset.cargo}</p>
          <p><strong>Instituci車n:</strong> ${this.dataset.institucion}</p>
          <hr>
          <p>${this.dataset.bio}</p>
        `,
        icon: "question",
        confirmButtonColor: "#5B0FA6"
      });
    });
  });

});

// SCROLL ANIMATION
const reveals = document.querySelectorAll(".reveal");

function revealOnScroll() {
  const windowHeight = window.innerHeight;

  reveals.forEach(el => {
    const elementTop = el.getBoundingClientRect().top;

    if (elementTop < windowHeight - 80) {
      el.classList.add("active");
    }
  });
}

window.addEventListener("scroll", revealOnScroll);

<script>

function cambiarFacultad(facultad, btn){

  // botones
  document.querySelectorAll('.fac-btn')
    .forEach(b => b.classList.remove('activo'));

  btn.classList.add('activo');

  // paneles
  document.querySelectorAll('.facultad-panel')
    .forEach(p => p.classList.remove('activo'));

  document
    .querySelector(`[data-facultad="${facultad}"]`)
    .classList.add('activo');
}

</script>