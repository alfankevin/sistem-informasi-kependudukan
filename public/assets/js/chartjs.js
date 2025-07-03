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
    maintainAspectRatio: false,
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
    maintainAspectRatio: false,
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
        'rgb(82, 205, 255)',
        'rgb(129, 218, 218)',
        'rgb(253, 208, 199)',
      ],
      label: 'Golongan Darah'
    }],
    labels: labelDarah,
  },
  options: {
    maintainAspectRatio: false,
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
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      position: 'right',
    },
  }
});

// console.log(dataStunting);
// console.log(labelStunting);

var ctx = document.getElementById("stunting").getContext('2d');
var stunting = new Chart(ctx, {
    type: 'pie',
    data: {
        datasets: [{
            data: dataStunting,
            backgroundColor: labelStunting.map(label =>
                label === 'Gizi buruk/stunting' ? 'rgb(220, 53, 69)' :
                label === 'Gizi lebih/obesitas' ? 'rgb(255, 193, 7)' :
                'rgb(40, 167, 69)'
            ),
            label: 'Risiko Stunting'
        }],
        labels: labelStunting,
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            position: 'bottom',
        },
        title: {
            display: true,
            text: 'Risiko Stunting'
        }
    }
});

var stuntingMonthlyCtx = document.getElementById("stuntingMonthlyChart").getContext('2d');
var stuntingMonthlyChart;

function loadStuntingMonthlyChart(year) {
    $.ajax({
        url: '/dashboard/stunting-chart-data',
        type: 'GET',
        data: { year: year },
        success: function(response) {
            // Update year filter options
            var yearFilter = $('#yearFilter');
            yearFilter.empty();
            $.each(response.years, function(index, year) {
                yearFilter.append($('<option>', {
                    value: year,
                    text: year
                }));
            });
            yearFilter.val(year);

            // Destroy previous chart if exists
            if (stuntingMonthlyChart) {
                stuntingMonthlyChart.destroy();
            }

            // Create new chart
            stuntingMonthlyChart = new Chart(stuntingMonthlyCtx, {
                type: 'bar',
                data: {
                    labels: response.months,
                    datasets: [{
                        label: 'Jumlah Kasus',
                        data: response.totals,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1,
                        type: 'bar',
                        order: 1
                    }, {
                        label: 'Trend Kasus',
                        data: response.totals,
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        type: 'line',
                        pointRadius: 4,
                        pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                        order: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            });
        }
    });
}

// Initialize with current year
loadStuntingMonthlyChart(new Date().getFullYear());

// Year filter change event
$('#yearFilter').change(function() {
    loadStuntingMonthlyChart($(this).val());
});

var ctx = document.getElementById("stuntinByAgeGroup").getContext('2d');
var stuntingByAge = new Chart(ctx, {
  type: 'bar',
  data: {
    datasets: [{
      label: 'Total',
      data: stuntingByAgeData,
      backgroundColor: 'rgba(220, 53, 69, 0.7)',
      borderColor: 'rgba(220, 53, 69, 0.7)',
      borderWidth: 2.5,
      pointBackgroundColor: '#ffffff',
      pointRadius: 4,
      barPercentage: 0.5,
    }],
    labels: stuntingByAgeLabels
  },
  options: {
    maintainAspectRatio: false,
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
        },

      }]
    },
  }
});
