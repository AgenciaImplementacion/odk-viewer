require('./utils');

var randomScalingFactor = function() {
  return Math.round(Math.random() * 100);
};

function graficarPie (id){
  //var url = require('file-loader!./pie.json');
  var url = 'https://ide.proadmintierra.info/odk/odk_actividad.php';
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
     var config = {
       type: 'pie',
       data: {
         datasets: [
           {
             data: data,
             backgroundColor: colorlist,
             label: 'Género'
           }
         ],
         labels: labels
       },
       options: {
         responsive: true,
         legend: {
           position: 'bottom',
         },
       }
     };
     var ctx = document.getElementById("chart-area").getContext("2d");
     window.myPie = new Chart(ctx, config);
  });
}

$( document ).ready(function() {
  graficarPie();
});
// window.onload = function() {
//
// };
