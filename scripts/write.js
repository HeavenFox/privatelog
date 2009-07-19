var hintShown = false;

function showHint()
{
	if (hintShown)
		return;
	hintShown = true;
	$('#key').append('<p>We encrypt title as well. Hence a hint should be set to help you remember what it is.</p><p><input type="text" name="hint" /></p>');
}

function specifyTime()
{
	now = new Date();
	$('#time_content').html(
	'<input type="text" name="year" value="' + now.getFullYear() + '" />' + 
	'-<input type="text" name="month" value="' + (now.getMonth()+1) + '" />' + 
	'-<input type="text" name="day" value="' + now.getDate() + '" />' + 
	'<input type="text" name="hour" value="' + now.getHours() + '" />' + 
	':<input type="text" name="minute" value="' + now.getMinutes() + '" />' + 
	':<input type="text" name="second" value="' + now.getSeconds() + '" />');
}