function displayPhStatistic(data, label) {
    var data = {
        labels: label.ph,
        datasets: [{
            label: "Ph Level of Water",
            fillColor: "rgba(220,220,220,0.2)",
            borderColor: "#2196F3",
            pointBackgroundColor: "#1976D2",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#FF5252",
            data: data.ph,
            lineTension: 0
        }]
    };

    var option = {
        responsive: true,
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false
            }]
        }
    };
    // Get the context of the canvas element we want to select
    var ctx = document.getElementById("phReport").getContext('2d');
    var myPhChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: option
    });


}

function displayTurbidStatistic(data, label) {
    var data2 = {
        labels: label.turbidity,
        datasets: [{
            label: "Turbidity Level of Water",
            fillColor: "rgba(220,220,220,0.2)",
            borderColor: "#00C851",
            pointBackgroundColor: "#007E33",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#FF5252",
            data: data.turbidity,
            lineTension: 0
        }]
    };

    var option2 = {
        responsive: true,
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false
            }]
        }
    };
    // Get the context of the canvas element we want to select
    var ctx2 = document.getElementById("turbidReport").getContext('2d');
    var myTurbidChart = new Chart(ctx2, {
        type: 'line',
        data: data2,
        options: option2
    });
}

function displayTempStatistic(data, label) {
    var data3 = {
        labels: label.temperature,
        datasets: [{
            label: "Temperature of Water",
            fillColor: "rgba(220,220,220,0.2)",
            borderColor: "#F44336",
            pointBackgroundColor: "#D32F2F",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#FF5252",
            data: data.temperature,
            lineTension: 0
        }]
    };

    var option3 = {
        responsive: true,
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false
            }]
        }
    };
    // Get the context of the canvas element we want to select
    var ctx3 = document.getElementById("myTemp").getContext('2d');
    var myTempChart = new Chart(ctx3, {
        type: 'line',
        data: data3,
        options: option3
    });
}

function displayPhStatisticAdmin(d, date, label) {
    var sets = [];
    for (var i = 0; i < label.length; i++) {
        sets.push({
            label: label[i],
            fillColor: "rgba(220,220,220,0.2)",
            borderColor: getRandomColor(),
            pointBackgroundColor: getRandomColor(),
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#FF5252",
            data: d[i].data,
            lineTension: 0
        })
    }

    var data = {
        labels: date,
        datasets: sets
    };

    var option = {
        responsive: true,
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false
            }]
        }
    };
    // Get the context of the canvas element we want to select
    var ctx = document.getElementById("phReport").getContext('2d');
    var myPhChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: option
    });


}

function displayTurbidStatisticAdmin(d, date, label) {
    var sets2 = [];
    for (var i = 0; i < label.length; i++) {
        sets2.push({
            label: label[i],
            fillColor: "rgba(220,220,220,0.2)",
            borderColor: getRandomColor(),
            pointBackgroundColor: getRandomColor(),
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#FF5252",
            data: d[i].data,
            lineTension: 0
        })
    }

    var data2 = {
        labels: date,
        datasets: sets2
    };

    var option2 = {
        responsive: true,
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false
            }]
        }
    };
    // Get the context of the canvas element we want to select
    var ctx2 = document.getElementById("turbidReport").getContext('2d');
    var myTurbidChart = new Chart(ctx2, {
        type: 'line',
        data: data2,
        options: option2
    });
}

function displayTempStatisticAdmin(d, date, label) {
    var sets3 = [];
    for (var i = 0; i < label.length; i++) {
        sets3.push({
            label: label[i],
            fillColor: "rgba(220,220,220,0.2)",
            borderColor: getRandomColor(),
            pointBackgroundColor: getRandomColor(),
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#FF5252",
            data: d[i].data,
            lineTension: 0
        })
    }

    var data3 = {
        labels: date,
        datasets: sets3
    };

    var option3 = {
        responsive: true,
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false
            }]
        }
    };
    // Get the context of the canvas element we want to select
    var ctx3 = document.getElementById("myTemp").getContext('2d');
    var myTempChart = new Chart(ctx3, {
        type: 'line',
        data: data3,
        options: option3
    });
}

function format_date(date) {
    date = date.substring(0, date.length - 3);
    var ex = date.split(":");

    if (parseInt(ex[0]) > 12) {
        return ex[0] % 12 + ":" + ex[1] + "PM";
    } else {
        return ex[0] + ":" + ex[1] + "AM";
    }
}

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}