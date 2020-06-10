import '../css/app.css';

require('select2');

let $ = require('jquery');
$('select').select2();

let contactButton = $('#contactButton');
contactButton.click(e => {
    e.preventDefault();
    $('#contactForm').slideDown();
    contactButton.slideUp();
})

console.log('Hello World Webpack Encore!!!');
