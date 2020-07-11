import '../css/app.css';
import Places from 'places.js';
import Map from './modules/map';
import 'slick-carousel';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

Map.init();

let inputAddress = document.querySelector('#property_address');
if(inputAddress !== null){
    let place = Places({
        container: inputAddress
    });
    place.on('change', e => {
        document.querySelector('#property_city').value = e.suggestion.city;
        document.querySelector('#property_postal_code').value = e.suggestion.postcode;
        document.querySelector('#property_lat').value = e.suggestion.latlng.lat;
        document.querySelector('#property_lng').value = e.suggestion.latlng.lng;
    })
}

let searchAddress = document.querySelector('#search_address');
if(searchAddress !== null){
    let place = Places({
        container: searchAddress
    });
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat;
        document.querySelector('#lng').value = e.suggestion.latlng.lng;
    })
}

require('select2');

let $ = require('jquery');
$('select').select2();

$('#slider').slick({
    dots: true,
    arrows: true
});

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