<?php
switch (IO::Inc('do'))
{
case 'logout':
	session_destroy();
	break;
}
?>