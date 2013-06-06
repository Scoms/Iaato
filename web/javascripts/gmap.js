var gmap;
var gMarkers = new Array();
var polyline;
var path;

$(function() {
  //J'utilise dans l'exemple jQuery pour améliorer la lisibilité du code, le focus étant sur GoogleMaps
 
  //tout d'abord on définit le centre de notre map par sa latitude et longitude, par exemple Montpellier: 
  if(list_step[0] != null)
    var latLng = new google.maps.LatLng(-list_step[0][0],-list_step[0][1]);
  else
    var latLng = new google.maps.LatLng(-60,-60); 
  var pt = new google.maps.Point(10,10);
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

  var lineSymbol = {
    path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
    scale: 2.5,
  };

  polyline = new google.maps.Polyline({
    strokeColor:   'red', //on définit la couleur
    strokeOpacity: 0.5,       //l'opacité
    strokeWeight:  2,         //l'épaisseur du trait,
    icons: [{
      icon: lineSymbol,
      offset: '50%',
    }],
    map:           gmap       //la map à laquelle rattacher la polyline
  });
  path = polyline.getPath();


  for(var coor in list_step)
  {
      var i = 0;
      var mLatlng = new google.maps.LatLng(-list_step[coor][0],-list_step[coor][1]);
      for(var g in gMarkers){
        var gLatlng = gMarkers[g].getM().getPosition();
        if( gLatlng.equals(mLatlng) ){
          var c = gMarkers[g].getI().getContent();
          c += "<p>"+list_step[coor][3]+"</p><br/>";
          gMarkers[g].getI().setContent(c);
          i = 1;
        }
      }
      addSites(list_step[coor], i);  
  }
});	

function addSites(coor, i)
{

    var myLatlng = new google.maps.LatLng(-coor[0],-coor[1]);
    path.push(myLatlng);
    if(i != 1){
      var marker = new google.maps.Marker({ position: myLatlng, title: coor[2]});
      marker.setMap(gmap);
      var content = "<div><strong>"+coor[2]+"</strong><br/>";
      content += "<p>"+coor[3]+"</p>";
      var infowindow = new google.maps.InfoWindow({ content: content } );
      gMarkers.push(new GMarkerClass(marker, infowindow));  
    }
}

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

GMarkerClass.prototype = {
    getM: function() {return this.m;},
    getI: function() {return this.i;}
}