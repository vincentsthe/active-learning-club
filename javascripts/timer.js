function createTimer(seconds){
		totalSeconds = seconds;
		Tick();
}

function Tick(){
	totalSeconds -= 1;
	if (totalSeconds > 0){
		$("#timer").html(timerHTML(totalSeconds));
	} else {
		$("#save-answer").hide();
		$("#timer").hide();
	}
	window.setTimeout("Tick()",1000);
}

function timerHTML(seconds){
	var hour = Math.floor(seconds / 3600);
	var min = Math.floor((seconds %3600)/60);
	var sec = seconds%60;
	return ""+hour+":"+min+":"+sec;
}
