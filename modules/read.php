<?php
$db = Database::Get();

$condition = array();

switch (IO::Inc('do'))
{
case 'decrypt':
	break;
}

//---------------------------------
// Parse conditions
//---------------------------------
$condition['page'] = IO::Inc('page');
$condition['date'] = IO::Inc('date');
?>