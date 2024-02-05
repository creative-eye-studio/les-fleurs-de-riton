/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/web/app.scss';

// start the Stimulus application
import './bootstrap';
import Viewer from 'viewerjs';

import { ScrollWeb } from './smoothScroll';
import { Parallax } from './parallax';
import { createApp } from 'vue';
import AOS from 'aos';
import MobileDetect from 'mobile-detect';
import Services from './vue/controllers/Services';
import Contact from './vue/controllers/Contact';

// Variables
// -----------------------------------------------
var htmlContent = document.querySelector('html');
const pageDatas = document.querySelector('body');
const values = {
  damping: pageDatas.dataset.damping,
  scrollImgSpeed: pageDatas.dataset.scrollimg
};


// Instantieur
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  const app = createApp({
    components: { Services, Contact },
    mounted() {
      const md = new MobileDetect(window.navigator.userAgent);
      if (!md.mobile()) {
        parallax();
        scrollWeb();
      } else {
        AOS.init({ disable: 'mobile' })
      }
    }
  });

  app.mount('#website');
});


// Smooth Scrollbar
// -----------------------------------------------
function scrollWeb() {
  const scrollWeb = new ScrollWeb(values.damping);
  scrollWeb.init;
  return scrollWeb;
}


// Parallax
// -----------------------------------------------
function parallax() {
  const parallax = new Parallax(values.damping, values.scrollImgSpeed);
  parallax.initParallax();
  return parallax;
}


// Menu Nav
// -----------------------------------------------
var htmlContent = document.querySelector('html');

document.querySelectorAll('.toggle-nav').forEach(btn => {
  btn.addEventListener('click', function () {
    htmlContent.classList.toggle('nav-open');
  });
});

document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', function () {
    htmlContent.classList.remove('nav-open');
  });
});


// Smooth Scroll
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
  anchorLink().forEach(function (link) {
    link.addEventListener('click', function (e) {
      // Empêcher le comportement par défaut du lien
      e.preventDefault();

      // Récupérer l'ID de l'ancre cible
      const targetId = this.getAttribute('href').substring(1);

      // Faire défiler jusqu'à l'ancre cible sans changer l'URL
      scrollSmoothly(targetId);

      return false;
    });
  });

  function scrollSmoothly(targetId) {
    const targetElement = document.getElementById(targetId);
    if (targetElement) {
      // Calculer la position de l'ancre cible
      const targetOffset = targetElement.offsetTop - 80;

      // Effectuer le défilement en douceur vers l'ancre cible
      const scrollOptions = {
        top: targetOffset,
        behavior: 'smooth'
      };
      window.scrollTo(scrollOptions);
    }
  }

  function anchorLink() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    return anchorLinks;
  }
})


// Loader Site
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
  function closeLoader() {
    document.querySelector('.loader').classList.add('open');
  }

  setTimeout(closeLoader, 3000);
})


// Formulaire de contact AJAX
// -----------------------------------------------
function formAJAX(formId, formResultId) {
  var form = document.querySelector(formId);

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();

    xhr.open(form.getAttribute('method'), form.getAttribute('action'), true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var resultElement = document.querySelector(formResultId);
        resultElement.innerHTML = xhr.responseText;
      }
    };
    xhr.send(formData);
  })
}
