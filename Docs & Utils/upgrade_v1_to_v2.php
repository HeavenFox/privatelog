<?php
// Enter plain password here
$PASSWORD = 'admin';
echo 'PrivateLog v1 to v2 Upgrader<br />';
echo 'Assuming AES & ECB which is default<br />';
require 'init.php';
require 'settings.php';
require ROOT . 'classes/database/Database.php';
require ROOT . 'classes/crypt/Crypt.php';
$conn = Database::Get();

$result = $conn->prepare('SELECT id, title, content FROM `pl_posts` WHERE `key` = ?');
$result->execute(array(sha1($PASSWORD)));
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
mcrypt_generic_deinit($mc);
mcrypt_module_close($mc);

?>