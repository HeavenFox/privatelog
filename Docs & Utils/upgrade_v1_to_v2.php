<html><head>
<?php
// Enter plain password here
$PASSWORD = 'admin';
// Per page limitation
$LIMIT = 15;
require 'init.php';
require 'settings.php';
require ROOT . 'classes/database/Database.php';
require ROOT . 'classes/crypt/Crypt.php';
$conn = Database::Get();


$begin = isset($_REQUEST['begin']) ? intval($_REQUEST['begin']) : 0;

$result = $conn->query('SELECT id, title, content FROM `pl_posts` WHERE `key` = \''.sha1($PASSWORD)."' LIMIT 0,{$LIMIT}");

$rowCount = $result->rowCount();
if ($rowCount > 0)
{
	echo '<meta http-equiv="refresh" content="3" />';
}
?>
</head><body>
<?php
echo 'PrivateLog v1 to v2 Upgrader<br />';
echo 'Assuming AES & ECB which is default<br />';
echo 'Found '.$rowCount.' entries<br />';


require ROOT . 'classes/Post.php';
$mc = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
mcrypt_generic_init($mc, md5($PASSWORD,true),'');
foreach ($result as $postData)
{
	$post = new Post;
	$post->fetch($postData['id']);
	$post->isCipher = false;
	$post->title = trim(mdecrypt_generic($mc, base64_decode($postData['title'])),"\0");
	$post->content = trim(mdecrypt_generic($mc, base64_decode($postData['content'])),"\0");
	$post->algorithm = 'aes';
	$post->mode = 'cbc';
	$post->encrypt($PASSWORD);
	$post->send();
	echo 'Post '.$postData['id'].' solved<br />';
}
if ($rowCount > 0)
{
	echo 'You will be redirected. <a href="upgrade_v1_to_v2.php">Continue instantly</a>';
}
mcrypt_generic_deinit($mc);
mcrypt_module_close($mc);

?>
</body></html>