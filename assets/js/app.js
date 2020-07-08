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

// Suppression des images
document.querySelectorAll('a[data-delete]')
    .forEach(a => {
        a.addEventListener('click', e => {
            e.preventDefault();
            fetch(a.getAttribute('href'), {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({'_token': a.dataset.token})
            }).then(response => response.json())
            .then(data => {
                if(data.success){
                    a.parentNode.parentNode.removeChild(a.parentNode);
                } else {
                    alert(data.error);
                }
            })
            .catch(e => alert(e))
        })});

console.log('Hello World Webpack Encore!!!');
