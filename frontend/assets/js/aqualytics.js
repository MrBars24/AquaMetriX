var device_id = 2,
    myPhChart, myTempChart, myTurbidChart;
//dev
var host = "http://localhost";
var socket = io.connect("http://localhost:8080/", { reconnect: true });
//prod
/*var host = "http://aquathesis-bbylvs.rhcloud.com";
var socket = io(host);*/
var Aqualytics = function() {
    return this;
}

Aqualytics = {
    init: function() {
        device_id = localStorage.getItem("activeDev");
        return Aqualytics;
    },
    getLog: function(page, callback) {
        $.ajax({
            url: host + "/AquaMetriX/backend/api/v1/device/log/" + device_id + "?page=" + page + "&offset=10",
            type: "GET",
            dataType: "JSON",
            success: function(result) {
                if (result.results != null)
                    callback(result.results, result.max_page)
            }
        })
    },
    fixPagination: function(pg, links, max) {
        var start = pg - links;
        if (start < 1) {
            start = 1;
        }

        var end = pg + links;
        if (end > max) {
            end = max;
        }
        for (var i = start; i <= end; i++) {
            if (i == page) {
                $("ul.pagination li:last").before(`<li class="page-item page-number active"><span class="page-link">${i}</span>
                    </li>`);
            } else {
                $("ul.pagination li:last").before(`<li class="page-item page-number"><span class="page-link">${i}</span>
                        </li>`);
            }
        }
    },
    getData: function() {
        Aqualytics.initMeter();
        Aqualytics.updateMeter(7);
        Aqualytics.initPh();
        Aqualytics.initTemp();
        Aqualytics.initTurbid();
    },
    initPh: function() {
        var data = {
            labels: ["", "", "", "", "", "", ""],
            datasets: [{
                label: "Ph Level of Water",
                fillColor: "rgba(220,220,220,0.2)",
                borderColor: "#2196F3",
                pointBackgroundColor: "#1976D2",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#FF5252",
                data: [7, 7, 7, 7, 7, 7, 7],
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
        var ctx = document.getElementById("myChart").getContext('2d');
        myPhChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: option
        });
    },
    initTemp: function() {
        var dta = {
            labels: ["6AM", "9AM", "12PM", "3PM", "6PM", "9PM", "12AM"],
            datasets: [{
                label: "Temperature of Water",
                fillColor: "rgba(220,220,220,0.2)",
                borderColor: "#F44336",
                pointBackgroundColor: "#D32F2F",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#FF5252",
                data: [25, 25, 25, 25, 25, 25, 25],
                lineTension: 0
            }]
        };

        var opt = {
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
        var ctx2 = document.getElementById("myTemp").getContext('2d');
        myTempChart = new Chart(ctx2, {
            type: 'line',
            data: dta,
            options: opt
        });
    },
    initTurbid: function() {
        var data = {
            labels: ["", "", "", "", "", "", ""],
            datasets: [{
                label: "Turbidity Level of Water",
                fillColor: "rgba(220,220,220,0.2)",
                borderColor: "#00C851",
                pointBackgroundColor: "#007E33",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#FF5252",
                data: [7, 7, 7, 7, 7, 7, 7],
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
        var ctx = document.getElementById("myTurbid").getContext('2d');
        myTurbidChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: option
        });
    },
    initMeter: function() {
        var data = {
            labels: [
                "pH level 1",
                "pH level 2",
                "pH level 3",
                "pH level 4",
                "pH level 5",
                "pH level 6",
                "pH level 7",
                "pH level 8",
                "pH level 9",
                "pH level 10",
                "pH level 11",
                "pH level 12",
                "pH level 13",
                "pH level 14",
            ],
            datasets: [{
                data: [13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13],
                backgroundColor: [
                    "#ee1c25",
                    "#f26724",
                    "#f8c611",
                    "#f5ed1c",
                    "#b5d333",
                    "#84c341",
                    "#4db749",
                    "#33a94b",
                    "#22b46b",
                    "#0ab8b6",
                    "#4690cd",
                    "#3853a4",
                    "#5a51a2",
                    "#63459d",
                    "#462c83"
                ]
            }]
        };

        var option = {
            circumference: 1 * Math.PI,
            rotation: 1 * Math.PI,
            cutoutPercentage: 80,
            tooltips: false,
            legend: {
                display: false,
                labels: {
                    display: false
                }
            }
        }

        var ctx = document.getElementById("myPie").getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: option
        });

    },
    addPhData: function(data) {
        if (myPhChart != null || myPhChart != undefined) {
            if (myPhChart.data.datasets[0].data.length < 7) {
                myPhChart.data.datasets[0].data.push(data);
            } else {
                myPhChart.data.datasets[0].data.push(data);
                myPhChart.data.datasets[0].data.shift(data);
            }
            myPhChart.update();
        }
    },
    addTempData: function(data) {
        if (myTempChart != null || myTempChart != undefined) {
            if (myTempChart.data.datasets[0].data.length < 7) {
                myTempChart.data.datasets[0].data.push(data);
            } else {
                myTempChart.data.datasets[0].data.push(data);
                myTempChart.data.datasets[0].data.shift(data);
            }
            myTempChart.update();
        }
    },
    addTurbData: function(data) {
        if (myTurbidChart != null || myTurbidChart != undefined) {
            if (myTurbidChart.data.datasets[0].data.length < 7) {
                myTurbidChart.data.datasets[0].data.push(data);
            } else {
                myTurbidChart.data.datasets[0].data.push(data);
                myTurbidChart.data.datasets[0].data.shift(data);
            }
            myTurbidChart.update();
        }
    },
    addUser: function(params) {
        $.ajax({
            url: host + "/AquaMetriX/backend/api/v1/user",
            type: "POST",
            data: params,
            success: function(data) {
                window.users = data;
                if (data != 0) {
                    $('#addUser').modal('hide')
                    toastr["info"]("User has been added.");
                    $("#table-users").prepend(`<tr>
                            <td class="user-id" scope="row">${data.id}</td>
                            <td class="user-firstname">${data.firstname}</td>
                            <td class="user-lastname">${data.lastname}</td>
                            <td class="user-email">${data.email}</td>
                            <td class="device-num">${data.devices}</td>
                            <td>
                                <a id="viewDevice" class="blue-text"><i class="fa fa-eye"></i></a>
                                <a id="addDevice" data-id="${data.id}" class="teal-text"><i class="fa fa-plus"></i></a>
                                <a id="editUser" class="teal-text"><i class="fa fa-pencil"></i></a>
                                <a id="deleteUser" class="red-text"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>`);
                }
            }
        })
    },
    editUser: function(params, element) {
        $.ajax({
            url: host + "/AquaMetriX/backend/api/v1/user/update/" + user_id,
            type: "POST",
            data: params,
            success: function(data) {
                if (data == 0) {
                    toastr["info"]("There is no changes made.");
                } else {
                    console.log(data,params)                    
                    element.parent().parent().find("td.user-email").text(data.email);
                    element.parent().parent().find("td.user-firstname").text(data.firstname);
                    element.parent().parent().find("td.user-lastname").text(data.lastname);
                    toastr["info"]("User info has been updated.");
                }
            }
        })
    },
    addDevice: function(params, id) {
        if (id != null) window.user_id = id;
        $.ajax({
            url: "/AquaMetriX/backend/api/v1/device",
            type: "POST",
            data: params + '&user_id=' + user_id,
            success: function(data) {
                console.log(data);
                if (data != 0) {
                    if (id != null) {
                        $("#table-device").append(`<tr>
                        <td class="device-id" scope="row">${data.device_id}</td>
                        <td class="device-address">${data.address}</td>
                        <td class="device-lat">${data.lat}</td>
                        <td class="device-lng">${data.lng}</td>
                        <td>
                            <a id="editDevice" class="teal-text"><i class="fa fa-pencil"></i></a>
                            <a id="deleteDevice" class="red-text"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>`);
                        $("#addModal").modal("hide");
                    } else {
                        $('#addModal').modal('hide')
                        var a = $("tr:nth-child(" + window.table_index + ") > td.device-num");
                        console.log(a.text());
                        var newvalue = parseInt(a.text()) + 1;
                        a.html(newvalue)
                        console.log(a.text());
                    }
                    $("#addModal").modal("hide");
                    toastr["info"]("device has been added.");
                }
            }
        })
    },
    editDevice: function(params,id) {
        $.ajax({
            url: host + "/AquaMetriX/backend/api/v1/device/update/" + id,
            type: "POST",
            dataType:"JSON",
            data: params,
            success: function(data) {
                console.log(data)
                if (data == 0) {
                    toastr["info"]("There is no changes made.");
                } else {
                    row.find("td.device-address").text(data.address);
                    row.find("td.device-lat").text(data.lat);
                    row.find("td.device-lng").text(data.lng);
                    toastr["info"]("Device info has been updated.");
                    $("#addModal").modal("hide");
                }
            }
        })
    },
    updateTemperature: function(temp) {
        $("span.deg").text(temp);
        Aqualytics.addTempData(temp)
    },
    updateTurbidity: function(turb) {
        $("span.turb").text(turb);
        Aqualytics.addTurbData(turb)
    },
    updateMeter: function(level) {
        $("span.ph").text(level);
        level = parseInt(level);
        level = Math.ceil(level);
        Aqualytics.addPhData(level);
        var needle = $("img.needle");
        needle.removeClass(function(index, css) {
            return (css.match(/wlevel-\d{1,2}/g) || []).join(' ');
        })
        switch (level) {
            case 1:
                needle.addClass("wlevel-0");
                break;
            case 2:
                needle.addClass("wlevel-1");
                break;
            case 3:
                needle.addClass("wlevel-2");
                break;
            case 4:
                needle.addClass("wlevel-3");
                break;
            case 5:
                needle.addClass("wlevel-4");
                break;
            case 6:
                needle.addClass("wlevel-5");
                break;
            case 7:
                needle.addClass("wlevel-6");
                break;
            case 8:
                needle.addClass("wlevel-7");
                break;
            case 9:
                needle.addClass("wlevel-8");
                break;
            case 10:
                needle.addClass("wlevel-9");
                break;
            case 11:
                needle.addClass("wlevel-10");
                break;
            case 12:
                needle.addClass("wlevel-11");
                break;
            case 13:
                needle.addClass("wlevel-12");
                break;
            case 14:
                needle.addClass("wlevel-13");
                break;

        }
    },
    getUsersInfo: function() {
        $("div.progress").show();
        $.ajax({
            url: "/AquaMetriX/backend/api/v1/user/list",
            type: "GET",
            success: function(data) {
                window.users = data;
                for (var i = 0; i < data.length; i++) {
                    $("#table-users").append(`<tr>
                        <td class="user-id" scope="row">${data[i].id}</td>
                        <td class="user-firstname">${data[i].firstname}</td>
                        <td class="user-lastname">${data[i].lastname}</td>
                        <td class="user-email">${data[i].email}</td>
                        <td class="device-num">${data[i].devices}</td>
                        <td>
                            <a id="viewDevice" class="blue-text"><i class="fa fa-eye"></i></a>
                            <a id="addDevice" data-id="${data[i].id}" class="green-text"><i class="fa fa-plus"></i></a>
                            <a id="editUser" data-id="${i}" class="teal-text"><i class="fa fa-pencil"></i></a>
                            <a id="deleteUser" class="red-text"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>`);
                }
                $("div.progress").hide();
            }
        })
    },
    getUserDevices: function(callback, id) {
        if (id != null) {
            $.ajax({
                url: host + "/AquaMetriX/backend/api/v1/device/list/" + id,
                type: "GET",
                success: function(result) {
                    window.devices = result;
                    callback(result);
                }
            })
        } else {
            var json = JSON.parse(atob(localStorage.getItem("userdata")));
            callback(json.devices);
        }
    },
    getNotifications: function(callback) {
        var id = JSON.parse(atob(localStorage.getItem("userdata"))).id;
        $.ajax({
            url: host + "/AquaMetriX/backend/api/v1/notification/user/" + id,
            type: "GET",
            success: function(result) {
                window.notifs = result;
                callback(result);
            }
        })
    },
    userLogout: function() {
        localStorage.removeItem("userdata");
        localStorage.removeItem("activeDev");
        location.href = "../login.html";
    },
    connectionNotif: function(type, msg) {
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "hideDuration": "300",
            "positionClass": "toast-bottom-right",
        }

        toastr[type](msg);
    },
    getParameterByName: function(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
}

$("a.logout").click(function() {
    Aqualytics.userLogout();
})

$(document).on("click", ".modal-card", function(e) {
    $(this).remove();
})

$(document).on("click", ".card-notif", function(e) {
    e.stopPropagation();
})

$('#myModal').on('show.bs.modal', function(e) {
    Aqualytics.getUserDevices(function(devices) {
        console.log(devices)
        for (var i = 0; i < devices.length; i++) {
            var act = (devices[i].device_id == device_id) ? "active" : "";
            $(".list-group").append(`<a href="#" data-id="${devices[i].device_id}" class="list-group-item pick-list ${act}">${devices[i].address}</a>`);
        }
    })
})

$('#myModal').on('hide.bs.modal', function(e) {
    $(".pick-list").remove();
})

$(document).on("click", ".pick-list", function() {
    device_id = $(this).attr("data-id");
    localStorage.setItem("activeDev", device_id);
    $('#myModal').modal('hide')
})

$$.statusChange({
    onConnect: function() {
        Aqualytics.connectionNotif("success", "Connected!");
    },
    onDisconnect: function() {
        Aqualytics.connectionNotif("error", "Disconnected!");
    }
})
