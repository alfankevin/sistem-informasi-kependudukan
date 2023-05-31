"use strict";

console.log(dataUmurL);
console.log(labelUmurL);
console.log(dataUmurP);
console.log(labelUmurP);

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: labelUmurL,
    datasets: [{
      label: 'Laki-laki',
      data: dataUmurL,
      borderWidth: 2,
      backgroundColor: 'rgba(0,123,255,.8)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
    },
    {
      label: 'Perempuan',
      data: dataUmurP,
      borderWidth: 2,
      backgroundColor: 'rgba(254,86,83,.7)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0 ,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
    }]
  },
  options: {
    legend: {
      display: true,
      position: 'bottom'
    },
    scales: {
      yAxes: [{
        gridLines: {
          // display: false,
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 10,
          callback: function(value, index, values) {
            return value;
          }
        }
      }],
      xAxes: [{
        gridLines: {
          display: false,
          tickMarkLength: 15,
        }
      }]
    },
  }
});

console.log(dataAgama);
console.log(labelAgama);

var ctx = document.getElementById("myChart4").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    datasets: [{
      data: dataAgama,
      backgroundColor: [
        '#191d21',
        '#6c757d',
        '#47c363',
        '#ffa426',
        '#fc544b',
        '#007bff',
      ],
      label: 'Agama'
    }],
    labels: labelAgama,
  },
  options: {
    responsive: true,
    legend: {
      position: 'right',
    },
  }
});

console.log(dataGolDarah);
console.log(labelGolDarah);

var ctx = document.getElementById("myChart5").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    datasets: [{
      data: dataGolDarah,
      backgroundColor: [
        '#47c363',
        '#ffa426',
        '#fc544b',
        '#007bff',
      ],
      label: 'Golongan Darah'
    }],
    labels: labelGolDarah,
  },
  options: {
    responsive: true,
    legend: {
      position: 'right',
    },
  }
});
