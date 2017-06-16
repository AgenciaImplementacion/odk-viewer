const config = {
  url_datos: 'https://geo.proadmintierra.info/geoserver/ODK/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ODK:datos&maxFeatures=50&outputFormat=application%2Fjson',
  path_imagenes: 'http://odk.proadmintierra.info/odk/piloto/',
  url_poligonos: 'https://geo.proadmintierra.info/geoserver/ODK/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ODK:poligono&maxFeatures=50&outputFormat=application%2Fjson'
};

export default config;
