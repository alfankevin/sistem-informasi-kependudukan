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
      pointRadius: 0,
      pointBackgroundColor: 'rgba(0, 123, 255, .8)',
      pointHoverBackgroundColor: 'rgba(0, 123, 255, .8)',
    },
    {
      label: 'Perempuan',
      data: dataUmurP,
      borderWidth: 2,
      backgroundColor: 'rgba(252, 84, 75, .7)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0,
      pointRadius: 0,
      pointBackgroundColor: 'rgba(252, 84, 75, .7)',
      pointHoverBackgroundColor: 'rgba(252, 84, 75, .7)',
    }]
  },
  options: {
    tooltips: {
      mode: 'index',
      intersect: false,
    },
    hover: {
      mode: 'nearest',
      intersect: true
    },
    legend: {
      display: false,
      position: 'bottom'
    },
    scales: {
      yAxes: [{
        gridLines: {
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

console.log(dataPekerjaan);
console.log(labelPekerjaan);

var ctx = document.getElementById("pekerjaan").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    datasets: [{
      label: 'Pekerjaan',
      data: dataPekerjaan,
      backgroundColor: '#007bff',
      borderColor: '#007bff',
      borderWidth: 2.5,
      pointBackgroundColor: '#ffffff',
      pointRadius: 4
    }],
    labels: labelPekerjaan
  },
  options: {
    indexAxis: 'y',
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
          stepSize: 20
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

console.log(dataDarah);
console.log(labelDarah);

var ctx = document.getElementById("darah").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: dataDarah,
      backgroundColor: [
        'rgb(31, 59, 179)',
        'rgb(253, 208, 199)',
        'rgb(82, 205, 255)',
        'rgb(129, 218, 218)',
      ],
      label: 'Golongan Darah'
    }],
    labels: labelDarah,
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
        'rgb(129, 218, 218)',
        'rgb(31, 59, 179)',
        'rgb(253, 208, 199)',
        'rgb(82, 205, 255)',
        '#34395e',
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