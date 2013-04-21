
$(function() {
  //J'utilise dans l'exemple jQuery pour améliorer la lisibilité du code, le focus étant sur GoogleMaps
 
  //tout d'abord on définit le centre de notre map par sa latitude et longitude, par exemple Montpellier: 
  var latLng = new google.maps.LatLng(-65.891683, 53.875732);
  //puis on créé la map
  var gmap = new google.maps.Map(document.getElementById('gmap-div'),
  {
    zoom: 3, //le zoom de départ
    center: latLng, //le centre de la map au chargement
    mapTypeId: google.maps.MapTypeId.SATELLITE, //le type de map, ROADMAP correspond à la version par défaut des versions précédentes
    streetViewControl: false, //si on souhaite désactiver les contrôle StreetView
    panControl: true //si on souhaite masquer les contrôles de déplacement
  });
  
  addSites(gmap);
     
});	

function addSites(gmap)
{
    var sites = new Array();
    sites.push(new google.maps.Marker({position: new google.maps.LatLng(-62.24, 59.47),map: gmap}));
    sites.push(new google.maps.Marker({position: new google.maps.LatLng(-64.14, 61.08),map: gmap}));     
}