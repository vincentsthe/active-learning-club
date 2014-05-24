function updateProblem(pid,problem){
	//update content
	$(".p-content[rel="+pid+"]").html(problem["content"]);
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
	$(".p-option_a[rel="+pid+"]").html(problem["option_a"]);
	$(".p-option_b[rel="+pid+"]").html(problem["option_b"]);
	$(".p-option_c[rel="+pid+"]").html(problem["option_c"]);
	$(".p-option_d[rel="+pid+"]").html(problem["option_d"]);
	$(".p-option_e[rel="+pid+"]").html(problem["option_e"]);
}

function updateProblemShort(pid,problem){
	$(".p-option_e[rel="+pid+"]").html(problem["answer"]);
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
		$("#server-info").html("Loading...");
		$("#server-info").show();
		loadProblemLoading = true;
		$.ajax({
			type 	: "POST",
			url		: loadProblemUrl,
			data 	: "pid="+pid,
			success : function(data){
				var po = JSON.parse(data);
				$(".p-container[rel='"+pid+"']").show();
				updateProblem(pid,po);
				$("#server-info").hide();
			},
			error : function(){
				$("#server-info").html("Error. Klik perbarui soal atau tekan F5");
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
$(".p-container").hide();
//$(".a-container").hide();
$(".p-show").click(function(){
	var pid = $(this).attr('rel');
	if ($(".p-content[rel="+pid+"]").html()==""){
		//alert("here");
		loadProblem(pid);
	} else {
		//alert($(".p-content[rel="+pid+"]").html());
	}
	$(".p-container[rel="+pid+"]").show();
	//$(".a-container[rel="+pid+"]").show();
});
$(".p-hide").click(function(){
	var pid = $(this).attr('rel');
	$(".p-container[rel="+pid+"]").hide();
	$(".a-container[rel="+pid+"]").hide();
});
$(".p-load").click(function(){
	var pid = $(this).attr('rel');
	loadProblem(pid);
	$(".p-container[rel="+pid+"]").show();
	//$(".a-container[rel="+pid+"]").show();
});
loadProblem(firstProblemId);
$(".p-container[rel="+firstProblemId+"]").show();
//$(".a-container[rel="+firstProblemId+"]").show();
});
//notify submit success
function nSS(){
$("#server-info").html("jawaban berhasil tersimpan");
$("#server-info").attr("class","success");
$("#server-info").show();
}
//notify submit error
function nSE(){
$("#server-info").html("Terjadi kesalahan. Ulangi atau tekan F5.");
$("#server-info").attr("class","danger");
$("#server-info").show();
}