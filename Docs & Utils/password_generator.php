<?php
echo sha1(md5($_REQUEST['key'],true));
?>
<form method='post' action='password_generator.php'><input name='key' /><input type='submit' value='calc' /></form>