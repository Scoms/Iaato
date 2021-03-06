var gmap;
var gMarkers = new Array();
var polyline;
var path;
$(function() {
  //J'utilise dans l'exemple jQuery pour améliorer la lisibilité du code, le focus étant sur GoogleMaps
 
  //tout d'abord on définit le centre de notre map par sa latitude et longitude, par exemple Montpellier: 
  if(list_ship[0] != null)
    var latLng = new google.maps.LatLng(-list_ship[0][0],-list_ship[0][1]);
  else
    var latLng = new google.maps.LatLng(-60,-60); 
  //puis on créé la map
  gmap = new google.maps.Map(document.getElementById('gmap-div'),
  {
    zoom: 5, //le zoom de départ
    center: latLng, //le centre de la map au chargement
    mapTypeId: google.maps.MapTypeId.SATELLITE, //le type de map, ROADMAP correspond à la version par défaut des versions précédentes
    streetViewControl: false, //si on souhaite désactiver les contrôle StreetView
    panControl: true //si on souhaite masquer les contrôles de déplacement
  });
  //addSites(-62.24, 59.47);
  //addSites(-64.14, 61.08);
  polyline = new google.maps.Polyline({
    strokeColor:   'red', //on définit la couleur
    strokeOpacity: 0.5,       //l'opacité
    strokeWeight:  3,         //l'épaisseur du trait,
    map:           gmap       //la map à laquelle rattacher la polyline
  });
  path = polyline.getPath();
  for(var infos in list_ship)
  {
      addShip(list_ship[infos]);
  }
});

function addShip(coor)
{
    var myLatlng = new google.maps.LatLng(-coor[0],-coor[1]);
    //path.push(myLatlng);
    var marker = new google.maps.Marker({ position: myLatlng, title: coor[2],
					 icon: "../../img/ship.png"
    });
    marker.setMap(gmap);
    var content = "<div  ><h5 style='color:#070975;'>"+coor[4]+"</h5>";
    content += "<h5>" + coor[2] + "</h5>";
    content += "<p>" + coor[3] + "</p></div>";
    var infowindow = new google.maps.InfoWindow({ content: content });
    gMarkers.push(new GMarkerClass(marker, infowindow));
}
/*
function addSites(coor)
{
    var myLatlng = new google.maps.LatLng(-coor[0],-coor[1]);
    path.push(myLatlng);
    var marker = new google.maps.Marker({ position: myLatlng, title: coor[2]});
    marker.setMap(gmap);
    var content = "<div><strong>" + coor[2] + "</strong><br/>";
    content += "<p>"+coor[3]+"</p>";
    content += "<p>"+coor[0]+";"+coor[1]+"</p></div>";
    var infowindow = new google.maps.InfoWindow({ content: content });
    gMarkers.push(new GMarkerClass(marker, infowindow));  
}
*/
GMarkerClass = function (mm, ii) {
    this.i = ii;
    this.m = mm;
    var self = this;
    google.maps.event.addListener(this.m, 'click', function () {
	for(var marker in gMarkers)
	{
	    gMarkers[marker].i.close(gmap,gMarkers[marker].m);
	}
        self.i.open(gmap, self.m);
    });
    
}