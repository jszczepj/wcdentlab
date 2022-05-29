function showNextProc(procId)
{
	var controlId = procId;
	var controlProcId = 'proc_' + controlId;
	document.getElementById(controlProcId).style.visibility = "visible"; // show body div tag
}

function hideNextProc(procId)
{
	var controlId = procId;
	var controlProcId = 'proc_' + controlId;
	document.getElementById(controlProcId).style.visibility = "hidden"; // hide body div tag
}
function showComment(commRow,commId)
{
	var controlCommentId = 'comment_' + commRow + '_' + commId;
	//alert(controlCommentId);
	document.getElementById(controlCommentId).style.visibility = "visible"; // show body div tag
}

function hideComment(commRow,commId)
{
	var controlCommentId = 'comment_' + commRow + '_' + commId;
	//alert(controlCommentId);
	document.getElementById(controlCommentId).style.visibility = "hidden"; // hide body div tag
}

