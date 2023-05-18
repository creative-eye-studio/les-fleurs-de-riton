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

import { ScrollWeb } from './smoothScroll';
import { Parallax } from './parallax';
import * as Vue from 'vue';

// Variables
// -----------------------------------------------
var htmlContent = document.querySelector('html');
var pageDatas = document.querySelector('body');
var values = {
    damping: pageDatas.dataset.damping,
    scrollImgSpeed: pageDatas.dataset.scrollimg
}


// Instantieur
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function(){
    Vue.createApp({}).mount('#website');
    scrollWeb();
    parallax();
})


// Smooth Scrollbar
// -----------------------------------------------
function scrollWeb() {
    let scrollWeb = new ScrollWeb(values.damping);
    scrollWeb.init;
    return scrollWeb;
}


// Parallax
// -----------------------------------------------
function parallax(){
    let parallax = new Parallax(values.damping, values.scrollImgSpeed);
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
// -----------------------------------------------
var tabs = require('tabs');
var container = document.querySelector('.tab-container');

if (container != null) {
    tabs(container);
}


// Smooth Scroll
// -----------------------------------------------
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

