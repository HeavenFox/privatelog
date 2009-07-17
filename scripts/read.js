$(document).ready(function(){
	$("#loading").hide();
})

function loading(is)
{
	if (is)
	{
		$("#loading").show().animate({opacity: 50},500);
	}
	else
	{
		$("#loading").animate({opacity: 0},500).hide();
	}
}

// Decrypt Function
function getContent(id)
{
	// Hide them
	$("#post-" + id).hide('slow',function(){
		key = $("#passwordfield-" + id).attr('value');
		$.get('index.php?act=read&do=decrypt', {id:id, key:key}, function(data){
			if (data)
			{
				$("#post-" + id).html(data);
				$("#post-" + id).show('slow');
			}
			else
			{
				$("#passwordfield-" + id).attr('value', '');
				$("#post-" + id).show('slow');
			}
		});
	}
	);
}

// Ajax effect doesn't seem beautiful
/*
function gotoPage(page)
{
	$('#main').hide(1000,function(){
		$.get('index.php?act=read&do=page', {page: page},function(data){
			$('#main').html(data);
			$('#main').show(1000);
		});
	});
}
*/