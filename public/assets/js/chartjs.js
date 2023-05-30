"use strict";

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["1-5", "6-10", "11-15", "16-20", "21-25", "26-30", "31-35", "36-40", "41-45", "46-50", "51-55", "56-60"],
    datasets: [{
      label: 'Laki-laki',
      data: [10, 90, 20, 130, 50, 90, 40, 70, 50, 110, 20, 65],
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
      data: [10, 20, 110, 50, 70, 40, 90, 50, 130, 20, 90, 50],
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
