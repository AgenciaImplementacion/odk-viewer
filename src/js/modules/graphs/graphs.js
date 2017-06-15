require('./utils');

var randomScalingFactor = function() {
  return Math.round(Math.random() * 100);
};

function graficarPie (id){
  var url = require('file-loader!./pie.json');
  console.log(url);
  $.ajax({url: url}).done(function(response) {
     console.log('response', response);
     var data = new Array();
     var labels = new Array();
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
             backgroundColor: [
               window.chartColors.red, window.chartColors.orange, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue
             ],
             label: 'Dataset 1'
           }
         ],
         labels: labels
       },
       options: {
         responsive: true
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
