/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/admin/app.scss';

// start the Stimulus application
import './bootstrap';


/* TABS
--------------------------------------------*/
var tabs = require('tabs');
var container = document.querySelector('.tab-container');

if (container != null) {
    tabs(container);
}


/* IMG TABS
--------------------------------------------*/
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.img-del');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/services/delete-image/' + id);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    // alert(response.message);
                    // Actualisez votre interface utilisateur en conséquence si nécessaire
                }
            };
            xhr.send();
            button.classList.add('deleted');
        });
    });
});