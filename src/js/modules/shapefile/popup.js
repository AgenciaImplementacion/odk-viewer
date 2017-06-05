import Select from 'ol/interaction/select';

var content = document.getElementById('popup-content');

var select_interaction = new Select();
select_interaction.on('select', function(evt) {
  console.log(evt);
  window.evt = evt;
  var coordinate = evt.mapBrowserEvent.coordinate;
  var message = lastFeature.getProperties().message;
  var objtag = lastFeature.getProperties().objtag;
  content.innerHTML = '<p>Mensaje: ' + message + '</p><br>' +
    '<p>Tag: ' + objtag + '</p>';
  window.overlay.setPosition(coordinate);
});

var lastFeature = null;
select_interaction.getFeatures().on("add", function(evt) {
  console.log(evt);
  window.evt2 = evt;
  var feature = evt.element; //the feature selected
  lastFeature = feature;
})

map.addInteraction(select_interaction);
