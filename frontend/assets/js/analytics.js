var tempState = "";
var turbState = "";
var phState = "";
var score = "";

function analyze(ph,temp,turb){
	var a = analyzePh(ph);
	var b = analyzeTemp(temp);
	var c = analyzeTurb(turb);

	var score = c+b+a;
	var analysis = [];
	var main = "";
	var color = "";
	$(".row-analysis").html("");
	console.log(score)
	switch(score){
		case '000':
			main = "BAD";
			color = "danger"
			analysis.push("Ph level and temperature is not good and water is not clear");
			analysis.push("Not suitable to raise any kind of fish");
			analysis.push(phState);
			analysis.push(tempState);
			break;
		case '100':
			main = "BAD";
			color = "danger"
			analysis.push("Water is clear but Ph level and temperature is not good");
			analysis.push("Not suitable to raise any kind of fish");
			analysis.push(phState);
			analysis.push(tempState);
			break;
		case '010':
			main = "BAD";
			color = "danger"
			analysis.push("Temperature is good but Ph level is not good");
			analysis.push(tempState);
			break;
		case '110':
			main = "BAD";
			color = "danger"
			analysis.push("Water is clear and temperature is good but Ph level is not good");
			analysis.push(phState);
			break;
		case '001':
			main = "BAD";
			color = "danger"
			analysis.push("Ph level is good but temperature is not good");
			analysis.push(tempState);
			break;
		case '101':
			main = "BAD";
			color = "danger"
			analysis.push("Ph level is good and water is clear but temperature is not good");
			analysis.push(tempState);
			break;
		case '011':
			main = "GOOD";
			color = "warning"
			analysis.push("Ph level and temperature is good");
			analysis.push(phState);
			analysis.push(tempState);
			break;
		case '111':
			main = "EXCELLENT";
			color = "success"
			analysis.push("Ph level and temperature is good and water is clear");
			analysis.push(phState);
			analysis.push(tempState);
			break;
		case '002':
			main = "BAD";
			color = "danger"
			analysis.push("Ph level and temperature is not good");
			analysis.push(phState);
			analysis.push(tempState);
			break;
		case '102':
			main = "BAD";
			color = "danger"
			analysis.push("Water is clear but Ph level and temperature is not good");
			analysis.push(phState);
			analysis.push(tempState);
			break;
		case '012':
			main = "AVERAGE";
			color = "warning"
			analysis.push("Temperature is good but watch for PH level");
			analysis.push(phState);
			break;
		case '112':
			main = "AVERAGE";
			color = "warning"
			analysis.push("Water is clear and temperature is good but watch for PH level");
			analysis.push(phState);
			break;
	}

	$(".col-remarks").html(`<div class="card card-primary text-xs-center z-depth-2">
                <div class="card-block">
                    <h3 class="white-text card-main">${main}</h3>
                </div>
            </div>`);
	for(var i=0;i<analysis.length;i++){
			$(".row-analysis").append(`
					<div class="col-md-6">
                <div class="card card-${color} text-xs-center z-depth-2">
                    <div class="card-block">
                        <h3 class="white-text">${analysis[i]}</h3>
                    </div>
                </div>
            </div>
				`);
	}
}

function analyzePh(ph){
	if(ph>6.5&&ph<9){
		if(ph>=8&&ph<8.5){
			phState = "Suitable for Fresh Water Fish and Salt Water Fish.";	
		}else{
			phState = "Suitable for Fresh Water Fish";
		}

		return "1";
	}

	if((ph>=5&&ph<6.5)||(ph>9&&ph<=10)){
		phState = "watch Ph level because fish may die";
		return "2";
	}

	if(ph<5||ph>10){
		phState = "Fish are almost dying.";
		return "0";
	}
}

function analyzeTemp(temp){
	if(temp>=15&&temp<=30){
		if(temp>=15&&temp<=18){
			tempState = "Suitable for Cold Water Fish";
		}else if(temp>18&&temp<23){
			tempState = "Suitable for Cool Water Fish";
		}else{
			tempState = "Suitable for Warm Water Fish";
		}
		return "1";	
	}else{
		tempState = "watch temperature because fish may die";
		return "0";
	}
}

function analyzeTurb(turb){
	if(turb>5){
		turbState = "Water is clear";
		return "1";
	}else{
		turbState = "Water is not clear";
		return "0";
	}
}