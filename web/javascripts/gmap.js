var gmap;
var gMarkers = new Array();
$(function() {
  //J'utilise dans l'exemple jQuery pour améliorer la lisibilité du code, le focus étant sur GoogleMaps
 
  //tout d'abord on définit le centre de notre map par sa latitude et longitude, par exemple Montpellier: 
  var latLng = new google.maps.LatLng(-65.891683, 53.875732);
  //puis on créé la map
  gmap = new google.maps.Map(document.getElementById('gmap-div'),
  {
    zoom: 3, //le zoom de départ
    center: latLng, //le centre de la map au chargement
    mapTypeId: google.maps.MapTypeId.SATELLITE, //le type de map, ROADMAP correspond à la version par défaut des versions précédentes
    streetViewControl: false, //si on souhaite désactiver les contrôle StreetView
    panControl: true //si on souhaite masquer les contrôles de déplacement
  });
  //addSites(-62.24, 59.47);
  //addSites(-64.14, 61.08);
  for(var coor in list_step)
  {
      addSites(list_step[coor]);
  }
});	

function addSites(coor)
{
    //alert(lg+" "+lt);
    gMarkers.push(new google.maps.Marker({
      position: new google.maps.LatLng(-coor[0],coor[1]),
      map: gmap,
      title: "ok",
    }));     
}