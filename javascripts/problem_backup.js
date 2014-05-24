/**
 * @var contestId the contestId
 * @var contestUrl the contestUrl
 */
$('document').ready(function(){

function isEmpty(el){
	return !$.trim(el.html());
}
//prevent overwhelming ajax request
var problemIsLoading = false;
$('.problem-nav-no').click(function(){loadProblem($(this).attr('rel')); });
function loadProblem(problemId){
	//if not loaded yet and not forced
	alert("hello");
	if (isEmpty($(".problem-container[rel="+problemId+"]")) && !problemIsLoading){
		problemIsLoading = true;
		$("#server-info").html("loading...");
		$("#server-info").show();
		$.ajax({
			type 	: "GET",
			url		: contestUrl+"?contestId="+contestId+"&problemId="+problemId,
			//data 	: "pid="+pid,
			success : function(){
				$("#server-info").hide();
				alert("ok");
			},
			error : function(){
				$("#server-info").html("coba refresh halaman.");
				alert("ok");
			}
		});
		loadProblemLoading = false;
	}
}

});