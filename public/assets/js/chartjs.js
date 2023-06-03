"use strict";

console.log(dataUmurL);
console.log(labelUmurL);
console.log(dataUmurP);
console.log(labelUmurP);

var ctx = document.getElementById("usia").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: labelUmurL,
    datasets: [{
      label: 'Laki-laki',
      data: dataUmurL,
      borderWidth: 2,
      backgroundColor: 'rgba(0, 123, 255, .8)',
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
      backgroundColor: 'rgba(252, 84, 75, .7)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(254,86,83,.7)',
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
          stepSize: 5,
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

var ctx = document.getElementById("pekerjaan").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    datasets: [{
      label: 'Pekerjaan',
      data: [46, 45, 33, 50, 43, 61, 48],
      borderWidth: 1,
      backgroundColor: '#007bff',
      borderColor: '#007bff',
      borderWidth: 2.5,
      pointBackgroundColor: '#ffffff',
      pointRadius: 4
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 10
        }
      }],
      xAxes: [{
        ticks: {
          display: true
        },
        gridLines: {
          display: false
        }
      }]
    },
  }
});

console.log(dataGolDarah);
console.log(labelGolDarah);

var ctx = document.getElementById("darah").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: dataGolDarah,
      backgroundColor: [
        'rgb(31, 59, 179)',
        'rgb(253, 208, 199)',
        'rgb(82, 205, 255)',
        'rgb(129, 218, 218)',
        // 'rgb(41, 156, 219)',
        // 'rgb(240, 101, 72)',
        // 'rgb(247, 184, 75)',
        // 'rgb(10, 179, 156)',
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

console.log(dataAgama);
console.log(labelAgama);

var ctx = document.getElementById("agama").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: dataAgama,
      backgroundColor: [
        '#191d21',
        '#34395e',
        'rgb(31, 59, 179)',
        'rgb(253, 208, 199)',
        'rgb(82, 205, 255)',
        'rgb(129, 218, 218)',
        // '#191d21',
        // 'rgb(64, 81, 137)',
        // 'rgb(41, 156, 219)',
        // 'rgb(240, 101, 72)',
        // 'rgb(247, 184, 75)',
        // 'rgb(10, 179, 156)',
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