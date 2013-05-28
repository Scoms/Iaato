var gmap;
var gMarkers = new Array();
var polyline;
var path;
$(function() {
  //J'utilise dans l'exemple jQuery pour améliorer la lisibilité du code, le focus étant sur GoogleMaps
 
  //tout d'abord on définit le centre de notre map par sa latitude et longitude, par exemple Montpellier: 
  var latLng = new google.maps.LatLng(-list_step[0][0],-list_step[0][1]);
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
    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
  };

  polyline = new google.maps.Polyline({
    strokeColor:   'red', //on définit la couleur
    strokeOpacity: 0.5,       //l'opacité
    strokeWeight:  2,         //l'épaisseur du trait,
    icons: [{
      path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
      //icon: lineSymbol,
      offset: '15',
      fillColor: 'green',
    }],
    map:           gmap       //la map à laquelle rattacher la polyline
  });
  path = polyline.getPath();
  
  var sites = new Array();
  var array_content = new Array();
  for(var cor in list_step){
      var name = cor[2];
      if($.inArray(name, sites) == -1){
        var content = "<div><strong>"+cor[2]+"</strong><br/><p>"+cor[3]+"</p>";
        /*
        array_content[name] = "<div><strong>"+cor[2]+"</strong><br/>";
        array_content[name] += "<p>"+cor[3]+"</p>";
        */
        array_content.push(content);
        sites.push(name);
      }
      else{
        array_content[name] += "<p>"+cor[3]+"</p>";
      }
      
  }
  
  

  //cpt = 0;
  for(var coor in list_step)
  {
      addSites(list_step[coor], array_content[coor[2]]); 
      //cpt+=1;  
  }
});	

function addSites(coor, content)
{
    var myLatlng = new google.maps.LatLng(-coor[0],-coor[1]);
    path.push(myLatlng);
    var marker = new google.maps.Marker({ position: myLatlng, title: coor[2]});
    marker.setMap(gmap);
    /*
    var content = "<div><strong>"+coor[2]+"</strong><br/>";
    content += "<p>"+coor[3]+"</p>";
    */
    content += "<p>"+coor[0]+";"+coor[1]+"</p></div>";
    var infowindow = new google.maps.InfoWindow({ content: content } );
    gMarkers.push(new GMarkerClass(marker, infowindow));  
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