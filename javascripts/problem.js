
function createTimer(seconds){
		totalSeconds = seconds;
		Tick();
}

function Tick(){
	totalSeconds -= 1;
	if (totalSeconds >= 0){
		$("#timer").html(timerHTML(totalSeconds));
	} else {
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

function updateProblem(pid,problem){
	$(".question[rel="+pid+"]").html(problem["content"]);
	//alert(problem["content"]);
	if (problem["type"]=='choice'){
		updateProblemChoice(pid,problem);
	} else if (problem["type"]=='short'){
		updateProblemShort(pid,problem);
	} else if (problem["type"]=='essay'){
		updateProblemEssay(pid,problem);
	}
}

function updateProblemChoice(pid,problem){
	$(".answer-a-content[rel="+pid+"]").html(problem["option_a"]);
	$(".answer-b-content[rel="+pid+"]").html(problem["option_b"]);
	$(".answer-c-content[rel="+pid+"]").html(problem["option_c"]);
	$(".answer-d-content[rel="+pid+"]").html(problem["option_d"]);
	$(".answer-e-content[rel="+pid+"]").html(problem["option_e"]);
}

function updateProblemShort(pid,problem){
}

function updateProblemEssay(pid,problem){

}

var loadProblemLoading = false;
function loadProblem(pid){
	//alert("load problem");
	//alert(contestUrl+"loadProblem");
	if (loadProblemLoading){
		//dont send AJAX request
	} else {
		loadProblemLoading = true;
		$.ajax({
			type 	: "POST",
			url		: contestUrl+"/loadProblem",
			data 	: "pid="+pid,
			success : function(data){
				var po = JSON.parse(data);
				$(".problem-container[rel='"+pid+"']").show();
				updateProblem(pid,po);
			},
			error : function(){
				signalConnectionError();
			}
		});
		loadProblemLoading = false;
	}
	
}
//prevent spamming of answer click.
var submitAnswerLoading = false;
function submitAnswer(pid,value){
	//var value = $(this).val();
	//alert(pid);
	$("a.p-no[rel="+pid+"]").attr('class','p-no');
	if (submitAnswerLoading){
		//dont send AJAX request.
	} else {
		submitAnswerLoading = true;
		//alert(pid);
		$.ajax({
			type : "POST",
			url  : contestUrl+"/submitAnswer",
			data : "pid="+pid+"&contestSubId="+contestSubId+"&value="+value,
			success: function(data){
				//$(".p-no[rel="+pid+"]").attr('style','color:#ffffff');
				$("a.p-no[rel="+pid+"]").attr('class','p-no answered');
				//$("#con-status").html('Koneksi tersambung');
				//$("#con-status").attr('style','color:green');
				submitAnswerLoading = false;
			},
			error : function(){
				//$("#con-status").html('koneksi terputus. Cek koneksi dan klik ulang tombol jawaban');
				//$("#con-status").attr('style','color:red');
				submitAnswerLoading = false;
				signalConnectionError();
			}
		});
	}
}

//ngasih tau user kalo error waktu submit jawaban.
//muncul pesan kesalahan
function signalConnectionError(){
	$("#con-status").html('koneksi terputus. periksa koneksi internet, lalu refresh halaman ini (tombol F5).');
	$("#con-status").attr('style','color:');
}


//answer process in pilgan
$(document).ready(function(){

$(".problem-container").hide();
loadProblem(firstProblemId);
$(".answer-pilgan").click(function(){
	var answer = $(this).val();
	var pid = $(this).attr('rel');
	submitAnswer(pid,answer);
	//alert(answer+" "+pid);
});


$(".p-no").click(function(){
	var no = $(this).attr('rel');
	$(".problem-container").hide();
	if ($(".question[rel="+no+"]").html() == ""){
		loadProblem(no);
	}
	$(".problem-container[rel="+no+"]").show();
});
$("#con-status").attr('style','color:#41ce31');
});
