function bmi_fun(bminumber){
  var xy="";
	var bmi=bminumber;

	if (bmi <= 18.5){
		xy=bmi*0.9;
		$("#bmi_text").html("당신의 비만도(BMI) 지수는 "+bmi+"로 <strong class=\"p-red\">“저체중”</strong> 입니다.");
	}else if(bmi > 18.5  && bmi < 23){
		xy=bmi*1.6;
		$("#bmi_text").html("당신의 비만도(BMI) 지수는 "+bmi+"로 <strong class=\"p-red\">“정상”</strong> 입니다.");
	}else if(bmi >= 23  && bmi < 25){
		if (bmi == 23){
			xy=bmi*1.73;
		} else {
			xy=bmi*2.1;
		}
		$("#bmi_text").html("당신의 비만도(BMI) 지수는 "+bmi+"로 <strong class=\"p-red\">“과체중”</strong> 입니다.");
	}else if(bmi >= 25  && bmi < 30){
		if (bmi <= 25){
			xy=parseInt(bmi*2.41);
		} else if (bmi <= 26){
			xy=bmi*2.47;
		} else if (bmi <= 27){
			xy=bmi*2.51;
		} else if (bmi <= 28){
			xy=bmi*2.57;
		} else if (bmi <= 29){
			xy=bmi*2.61;
		} else if (bmi < 30){
			xy=bmi*2.61;
		}
		$("#bmi_text").html("당신의 비만도(BMI) 지수는 "+bmi+"로 <strong class=\"p-red\">“비만”</strong> 입니다.");
	}else{
		if (bmi <= 30){
			xy=bmi*2.65;
		}else if (bmi <= 31){
			xy=bmi*2.68;
		}else if (bmi <= 32){
			xy=bmi*2.71;
		}else if (bmi <= 33){
			xy=bmi*2.74;
		}else{
			xy=34*2.77;
		}
		$("#bmi_text").html("당신의 비만도(BMI) 지수는 "+bmi+"로 <strong class=\"redorang2\">“고도비만”</em> 입니다.");
	}
	$("#bmicnt").html(bmi);
	if (bmi > 0){
		$("#grapnavi").css({"position":"absolute","top":"25px","display":"block","width":"28px","left":xy+"%"});
	}else{
		$("#grapnavi").css({"position":"absolute","top":"25px","display":"block","width":"28px","left":xy+"%"});
	}
}
