$(document).ready(function(){
	$("#loading").hide();
})

function loading(is)
{
	if (is)
	{
		$("#loading").fadeIn(1000);
	}
	else
	{
		$("#loading").fadeOut(1000);
	}
}

// Decrypt Function
function getContent(id)
{
	// Hide them
	$("#post-" + id).fadeOut('slow');
	
	key = $("#passwordfield-" + id).attr('value');
	$.get('index.php?act=read&do=decrypt', {id:id, key:key}, function(data){
		if (data)
		{
			$("#post-" + id).html(data);
			$("#post-" + id).fadeIn('slow');
		}
		else
		{
			$("#post-" + id).fadeIn('slow');
			$("#passwordfield-" + id).attr('value', '');
		}
	})
}