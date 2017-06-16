import serverConfig from 'conf/config';

import GeoJSON from 'ol/format/geojson';
import SourceVector from 'ol/source/vector';

import Style from 'ol/style/style';
import Stroke from 'ol/style/stroke';
import Circle from 'ol/style/circle';
import Fill from 'ol/style/fill';

import LayerVector from 'ol/layer/vector';

import Loadingstrategy from 'ol/loadingstrategy';
import Tilegrid from 'ol/tilegrid';

// format used to parse WFS GetFeature responses
var geojsonFormat = new GeoJSON();

//segunda capa poligono

var serviceSource2 = new SourceVector({
  loader: function(extent, resolution, projection) {
    //console.log('bad extent', extent, resolution, projection);
    var newExtent = window.map.getView().calculateExtent(window.map.getSize());
    //console.log('new extent', newExtent);
    //extent = newExtent.join(',');
    extent = newExtent;

    var url = serverConfig.url_poligonos + '&srsname=EPSG:3857&bbox=' + extent.join(',') + ',EPSG:3857'
    // use jsonp: false to prevent jQuery from adding the "callback"
    // parameter to the URL
    $.ajax({url: url, dataType: 'json', jsonp: false}).done(function(response) {
      serviceSource2.addFeatures(geojsonFormat.readFeatures(response))
    });
  },
  strategy: Loadingstrategy.tile(Tilegrid.createXYZ({maxZoom: 19}))
});

var serviceLayer2 = new LayerVector({
  source: serviceSource2,
  style: function(feature) {
    //console.log('serviceLayer2', feature.getGeometry().getType());
    return styles2[feature.getGeometry().getType()];
  }
});

//window.serviceLayer2 = serviceLayer2;
window.map.addLayer(serviceLayer2);

//termina segunda capa poligono

var serviceSource = new SourceVector({
  loader: function(extent, resolution, projection) {
    //console.log('bad extent', extent, resolution, projection);
    var newExtent = window.map.getView().calculateExtent(window.map.getSize());
    //console.log('new extent', newExtent);
    //extent = newExtent.join(',');
    extent = newExtent;

    var url = serverConfig.url_datos + '&srsname=EPSG:3857&bbox=' + extent.join(',') + ',EPSG:3857'
    // use jsonp: false to prevent jQuery from adding the "callback"
    // parameter to the URL
    $.ajax({url: url, dataType: 'json', jsonp: false}).done(function(response) {
      serviceSource.addFeatures(geojsonFormat.readFeatures(response))
    });
  },
  strategy: Loadingstrategy.tile(Tilegrid.createXYZ({maxZoom: 19}))
});

var serviceLayer = new LayerVector({
  source: serviceSource,
  style: function(feature) {
    return styles[feature.getGeometry().getType()];
  }
});

window.map.addLayer(serviceLayer);


//style1
var image = new Circle({
  radius: 5,
  fill: new Fill({
    color: 'rgba(223, 62, 62, 1)'
  }),
  stroke: new Stroke({
    color: 'rgba(116, 43, 8, 0.45)',
    width: 1
  })
});

var styles = {
  'Point': new Style({
    image: image
  }),
  'LineString': new Style({
    stroke: new Stroke({
      color: 'green',
      width: 1
    })
  }),
  'MultiLineString': new Style({
    stroke: new Stroke({
      color: 'green',
      width: 1
    })
  }),
  'MultiPoint': new Style({
    image: image
  }),
  'MultiPolygon': new Style({
    stroke: new Stroke({
      color: 'yellow',
      width: 1
    }),
    fill: new Fill({
      color: 'rgba(255, 255, 0, 0.1)'
    })
  }),
  'Polygon': new Style({
    stroke: new Stroke({
      color: 'blue',
      lineDash: [4],
      width: 3
    }),
    fill: new Fill({
      color: 'rgba(0, 0, 255, 0.1)'
    })
  }),
  'GeometryCollection': new Style({
    stroke: new Stroke({
      color: 'magenta',
      width: 2
    }),
    fill: new Fill({
      color: 'magenta'
    }),
    image: new Circle({
      radius: 5,
      fill: null,
      stroke: new Stroke({
        color: 'magenta'
      })
    })
  }),
  'Circle': new Style({
    stroke: new Stroke({
      color: 'red',
      width: 2
    }),
    fill: new Fill({
      color: 'rgba(255,0,0,0.2)'
    })
  })
};

//poligono styles

var styles2 = {
  'Point': new Style({
    image: image
  }),
  'LineString': new Style({
    stroke: new Stroke({
      color: 'green',
      width: 1
    })
  }),
  'MultiLineString': new Style({
    stroke: new Stroke({
      color: 'green',
      width: 1
    })
  }),
  'MultiPoint': new Style({
    image: image
  }),
  'MultiPolygon': new Style({
    stroke: new Stroke({
      color: 'rgb(58, 153, 0)',
      width: 1
    }),
    fill: new Fill({
      color: 'rgba(43, 255, 0, 0.1)'
    })
  }),
  'Polygon': new Style({
    stroke: new Stroke({
      color: 'blue',
      lineDash: [4],
      width: 3
    }),
    fill: new Fill({
      color: 'rgba(0, 0, 255, 0.1)'
    })
  }),
  'GeometryCollection': new Style({
    stroke: new Stroke({
      color: 'magenta',
      width: 2
    }),
    fill: new Fill({
      color: 'magenta'
    }),
    image: new Circle({
      radius: 10,
      fill: null,
      stroke: new Stroke({
        color: 'magenta'
      })
    })
  }),
  'Circle': new Style({
    stroke: new Stroke({
      color: 'red',
      width: 2
    }),
    fill: new Fill({
      color: 'rgb(255,0,0)'
    })
  })
};

window.masInformacion = function(id) {
   var url = 'https://ide.proadmintierra.info/odk/odk_p.php?id=' + id;
   $.ajax({url: url}).done(function(response) {
      console.log('response', response);
      var properties = response[0];

      var content = document.getElementById('contenido-barra-lateral');
      var contentHTML = '';
      for (var property in properties) {
        if (properties.hasOwnProperty(property)) {
          if(properties[property]+'' !== 'null'){
            contentHTML += '<span><b class="titulo-propiedades">' + property + ':</b><br/> ' + properties[property] + '</span><br/>';
          }
        }
      }
      content.innerHTML = contentHTML;
   });
}
