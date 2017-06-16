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

var Color = require('color');

//segunda capa poligono
function createLayer (filter, lastCharData) {
  var configLayer = {
    id: 'piloto-filtrado',
    filter: filter
  };
  map.removeLayer(map.getLayer(configLayer.id));
  var wfsLoader = function(extent, resolution, projection) {
    // var newExtent = window.map.getView().calculateExtent(window.map.getSize());
    // extent = newExtent;
    var indice = this.indice;
    var wfsSource = this;
    var url = serverConfig.url_poligonos + //'/geoserver/parqueaderos/ows?service=WFS&' +
    //'version=1.0.0&request=GetFeature&typename=parqueaderos:isla&' +
    //'outputFormat=application%2Fjson' +
    '&srsname=EPSG:3857&bbox=' + extent.join(',') + ',EPSG:3857';
    // use jsonp: false to prevent jQuery from adding the "callback"
    // parameter to the URL
    $.ajax({url: url, dataType: 'json', jsonp: false}).done(function(response) {
      var features = geojsonFormat.readFeatures(response);
      var filter = wfsSource.config.filter;
      if (typeof filter !== 'undefined' && filter !== '') {
        //window.features = features;
        features = features.filter(function(feature) {
          console.log('eval(filter)', eval(filter), wfsSource.config.id);
          return eval(filter);
        });
      }
      wfsSource.addFeatures(features);
    });
  };

  var serviceSource = new SourceVector({
    loader: wfsLoader,
    strategy: Loadingstrategy.tile(Tilegrid.createXYZ({maxZoom: 19}))
  });

  serviceSource.config = configLayer;

  var serviceLayer = new LayerVector({
    source: serviceSource,
    style: function(feature) {
      return styleFunction(feature, lastCharData);
    }
  });

  return serviceLayer;
}


//poligono styles
function styleFunction(feature, lastCharData){
  var codPredial = feature.get('cod_cat_rg').toString();
  var grupoDatos = lastCharData.find(function(element) {
    return element.predios.indexOf(codPredial) > -1;
  });

  if(typeof grupoDatos === 'undefined'){
    return null;
  }
  var colorStroke = grupoDatos.color;

  window.hola = Color(colorStroke);
  var colorFill = Color(colorStroke);
  colorFill = colorFill.fade(0.2).string();

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
        color: colorStroke,
        width: 1
      }),
      fill: new Fill({
        color: colorFill
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

  console.log('hi', feature.getGeometry().getType(), styles[feature.getGeometry().getType()]);

  return styles[feature.getGeometry().getType()];
}

export default createLayer;
