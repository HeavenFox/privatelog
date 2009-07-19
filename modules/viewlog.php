<?php
switch (IO::Inc('do'))
{
case 'clear':
	$table = null;
	if (IO::Inc('what') == 'admin')
	{
		$table = 'pl_adminlog';
	}
	if (IO::Inc('what') == 'attempt')
	{
		$table = 'pl_loginattempt';
	}
	if (!$table)
	{
		throw new Exception('Invalid action');
	}
	Database::Get()->query("TRUNCATE TABLE `{$table}`");
	break;
}
?>