var phPercent = 0.40;
var turbPercent = 0.20;
var tempPercent = 0.40;

function calculateInterpretation(scores) {
	try{
    var ph = calculatePerCategory("ph", scores.result.ph.data,phPercent);
    var turb = calculatePerCategory("turbidity", scores.result.turbidity.data,turbPercent);
    var temp = calculatePerCategory("temperature", scores.result.temperature.data,tempPercent);

    console.log("score:",parseFloat(ph[0]+turb[0]+temp[0]).toFixed(2) + "%");
    displayInterpretation(parseFloat(ph[0]+turb[0]+temp[0]).toFixed(2))
	}catch(e){
		$(".analytics").hide();
		$(".foot").show();
		$(".foot>div>h1").html("No Fetch Data");	
	}
}

function calculatePerCategory(category, scores, p) {
    var max = scores.length * 3;
    var sum = getSums(scores, "val", category);
    var arr = [];
    p = p * 100;
    arr[0] = (sum * p) / max;
    arr[1] = p;

    return arr;
    //console.log(sum + "/" + max);
}

function displayInterpretation(res){
	console.log(res);
	$(".analytics").show();
	$(".analytics>div").removeClass("card-success");
	$(".analytics>div").removeClass("card-warning");
	$(".analytics>div").removeClass("card-danger");

	if(res >= 90){
		$(".analytics>div").addClass("card-success");
		$(".report-remarks").html("Water Quality Condition is<br>EXCELLENT");
	}

	if(res >= 85 && res < 90){
		$(".analytics>div").addClass("card-warning");
		$(".report-remarks").html("Water Quality Condition is<br>GOOD");
	}

	if(res < 85){
		console.log("danger")
		$(".analytics>div").addClass("card-danger");
		$(".report-remarks").html("Water Quality Condition is<br>POOR");
	}

	$(".report-suggest").html("Water Quality Rating<br>" + res + "%");
}

function getSums(arr, key, category) {
    var sum = 0;
    for (var i = 0; i < arr.length; i++) {
        sum += getEquivalent(category, arr[i]["val"]);
    }

    return sum;
}

function getEquivalent(key, val) {
    switch (key) {
        case "ph":
            if (val >= 7 && val <= 8) {
                return 3;
            }

            if ((val >= 6 && val < 7) || (val >= 8 && val <= 9)) {
                return 2;
            }

            if (val > 9 && val < 6) {
                return 1;
            }

            break;
        case "turbidity":
            if (val >= 6) {
                return 3;
            }

            if (val < 6) {
                return 1;
            }

            break;

        case "temperature":
            if (val >= 25 && val <= 30) {
                return 3;
            }

            if (val >= 20 && val < 25) {
                return 2;
            }

            if (val > 30 && val < 20) {
                return 1;
            }

            break;
    }

    return 0;
}
