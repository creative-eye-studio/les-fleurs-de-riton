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
import AOS from 'aos';

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
    AOS.init();
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


// Service Tabs
// -----------------------------------------------
var serviceBtn = document.querySelectorAll('.service-btn');
serviceBtn.forEach(btn => {
    btn.addEventListener('click', function(){
        console.log('cliqué');
        console.log(btn.getAttribute('data-link'));
    })
})