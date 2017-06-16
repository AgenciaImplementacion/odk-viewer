require('./utils');

var randomScalingFactor = function() {
  return Math.round(Math.random() * 100);
};

window.graficarPie = function(value) {
  //var url = require('file-loader!./pie.json');
  var url = 'https://ide.proadmintierra.info/odk/' + value;
  console.log(url);
  $.ajax({url: url}).done(function(response) {
    console.log('response', response);
    var data = new Array();
    var labels = new Array();
    var colorlist = [
      window.chartColors.red,
      window.chartColors.orange,
      window.chartColors.yellow,
      window.chartColors.green,
      window.chartColors.blue,
      window.chartColors.purple,
      window.chartColors.gray
    ];
    for (var i = 0; i < response.length; i++) {
      var alias = response[i].alias;
      var numPredios = response[i].predios.length;
      labels.push(alias);
      data.push(numPredios);
    }
    if (typeof window.myPieConfig !== 'undefined') {
      window.myPieConfig.data.datasets.splice(0, 1); //Se elimina el anterior
      var newDataset = {
        backgroundColor: colorlist,
        data: data,
        label: 'Gráfica'
      };
      var newLabel = labels;
      window.myPieConfig.data.datasets.push(newDataset);
      window.myPieConfig.data.labels = newLabel;
      window.myPie.update();
      return;
    }
    window.myPieConfig = {
      type: 'pie',
      data: {
        datasets: [
          {
            data: data,
            backgroundColor: colorlist,
            label: 'Gráfica'
          }
        ],
        labels: labels
      },
      options: {
        responsive: true,
        legend: {
          position: 'bottom'
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              console.log(tooltipItem, data);
              var label = data.labels[tooltipItem.index];
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var value = dataset.data[tooltipItem.index];
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
              });
              var currentValue = dataset.data[tooltipItem.index];
              var precentage = Math.floor(((currentValue / total) * 100) + 0.5);
              return label + ": " + value + " Predios " + precentage + "%";
            }
          }
        }
      }
    };
    var ctx = document.getElementById("chart-area").getContext("2d");
    window.myPie = new Chart(ctx, window.myPieConfig);
  });
}

$(document).ready(function() {
  graficarPie('odk_actividad.php');
});
// window.onload = function() {
//
// };
