
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

class Map{
    static init(){
        let map = document.querySelector('#map');
        if(map === null){
            return;
        }
        
        let myIcon = L.icon({
            iconUrl: '/map/marker-icon.png'
        });
        let center = [map.dataset.lat, map.dataset.lng];
        map = L.map('map').setView(center, 14);
        let token = 'pk.eyJ1IjoiZngxMzAxMyIsImEiOiJjazVtaHdrNWowd3o0M2VwY3VnMnlieng0In0.DmnwTmUmlxMLbjvBw_5jDQ';
        L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}`, {
            maxZoom: 18,
            minZoom: 12,
            id: 'mapbox/streets-v11',
            accessToken: token,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>'
        }).addTo(map);
        L.marker(center, {icon: myIcon}).addTo(map);
    }
}

export default Map;