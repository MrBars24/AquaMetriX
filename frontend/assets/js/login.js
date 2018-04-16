var host = "http://localhost";

var Aqualytics = {
    login: function(serial) {
        $.ajax({
            url: host + "/AquaMetriX/backend/api/v1/user/login",
            type: "POST",
            data: serial,
            success: function(result) {
                if (result != "") {
                    var jstr = JSON.stringify(result);
                    localStorage.setItem("userdata", btoa(jstr));
                    console.log(result)
                    if(result.devices != null){
                        localStorage.setItem("activeDev", result.devices[0].device_id);
                    }
                    if (result.user_type == "admin") {
                        location.href = "./admin/dashboard.html";
                    }
                    if (result.user_type == "user") {
                        location.href = "./user/dashboard.html";
                    }
                } else {
                    alert("wala")
                }
            }
        })
    }
}
