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
import 'viewerjs/dist/viewer.css';
import Viewer from 'viewerjs';
import anime from 'animejs/lib/anime.es.js';
import * as Vue from 'vue';

import { ScrollWeb } from './smoothScroll';
import { Parallax } from './parallax';
import { createApp } from 'vue';
import AOS from 'aos';

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
document.addEventListener('DOMContentLoaded', function(){
    createApp({
    //     Configuration de votre application Vue.js
    }).mount('#website');
    AOS.init();
    scrollWeb();
    parallax();
});


// Img Converter
// -----------------------------------------------
function imgConverter(){
  let imgConverter = new ImgConverter();
  imgConverter.convertJpgToWebp;
  return imgConverter;
}


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
var navBtn = document.querySelectorAll('.toggle-nav');
navBtn.forEach(btn => {
    btn.addEventListener('click', function(){
        htmlContent.classList.toggle('nav-open');
    })
})

var navLink = document.querySelectorAll('.nav-link');
navLink.forEach(btn => {
    btn.addEventListener('click', function(){
        htmlContent.classList.remove('nav-open');
    })
})


// Service Tabs
// ----------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
  const firstTabBtn = document.querySelector('.service-btn');
  firstTabBtn.classList.add('active');
  const firstTab = document.querySelector('.service-block');
  firstTab.classList.add('active');
  // Récupérer les éléments de l'onglet et du contenu
  const tabs = document.querySelectorAll('.tab');
  const tabContent = document.querySelectorAll('.tab-content > section');

  // Ajouter un gestionnaire d'événements aux onglets
  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      // Supprimer la classe active de tous les onglets
      tabs.forEach((tab) => {
        tab.classList.remove('active');
      });

      // Masquer tous les contenus d'onglet
      tabContent.forEach((content) => {
        content.classList.remove('active');
      });

      // Récupérer l'identifiant de l'onglet correspondant
      const tabId = tab.getAttribute('data-tab');

      // Ajouter la classe active à l'onglet cliqué
      tab.classList.add('active');

      // Afficher le contenu de l'onglet correspondant
      const activeContent = document.getElementById(tabId);
      activeContent.classList.add('active');
    });
  });
});


// Smooth Scroll
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  anchorLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
      // Empêcher le comportement par défaut du lien
      event.preventDefault();

      // Récupérer l'ID de l'ancre cible
      const targetId = link.getAttribute('href').substring(1);

      // Faire défiler jusqu'à l'ancre cible sans changer l'URL
      scrollSmoothly(targetId);
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
})


// ViewerJS
// -----------------------------------------------
// You should import the CSS file.
document.addEventListener('DOMContentLoaded', function () {
  // View an image.
  const viewer = new Viewer(document.getElementById('image-viewer'), {
    inline: false,
    fullscreen: true,
    viewed() {
      viewer.zoomTo(1);
    },
  });
  // Then, show the image by clicking it, or call `viewer.show()`.

  // View a list of images.
  // Note: All images within the container will be found by calling `element.querySelectorAll('img')`.
  const gallery = new Viewer(document.getElementById('services-list'));
  // Then, show one image by click it, or call `gallery.show()`.
})


// AnimeJS
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
  var textWrapperTitle = document.querySelector('.main-title');
  textWrapperTitle.innerHTML = textWrapperTitle.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

  var textWrapperSubTitle = document.querySelector('.sub-title');
  textWrapperSubTitle.innerHTML = textWrapperSubTitle.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
  
  anime.timeline({loop: false})
    .add({
      targets: '.main-title .letter, .sub-title .letter',
      translateX: [40,0],
      translateZ: 0,
      opacity: [0,1],
      easing: "easeOutExpo",
      duration: 1200,
      delay: (el, i) => 500 + 30 * i
    })
})


// Loader Site
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
  function closeLoader(){
    document.querySelector('.loader').classList.add('open');
  }

  setTimeout(closeLoader, 3500);
})