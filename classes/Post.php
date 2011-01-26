<?php
class Post
{
	public $id;
	public $title;
	public $content;
	public $weather;
	public $location;
	public $ip;
	public $time;
	public $algorithm;
	public $mode;
	public $iv;
	
	public $key;
	public $salt;
	public $hint;
	
	public $decryptable;
	
	public $isCipher = false;
	
	const DECRYPT_INDICATOR = 'SUCCESS';
	
	public function fetch($id)
	{
		$db = Database::Get();
		
		$result = $db->query("SELECT * FROM `pl_posts` WHERE id = {$id}");
		
		if ($result->rowCount())
		{
			$this->fill($result->fetch(), true);
		}
	}
	
	public function fill($params, $isCipher)
	{
		$this->id = $params['id'];
		$this->title = $params['title'];
		$this->content = $params['content'];
		$this->time = $params['time'];
		$this->weather = $params['weather'];
		$this->location = $params['location'];
		$this->key = $params['key'];
		$this->salt = $params['salt'];
		$this->hint = $params['hint'];
		$this->ip = $params['ip'];
		$this->algorithm = $params['algorithm'];
		$this->mode = $params['mode'];
		$this->iv = $params['iv'];
		
		$this->isCipher = $isCipher;
	}
	
	public function encrypt($password)
	{
		if ($this->isCipher)
		{
			return false;
		}
		
		$c = Crypt::Get($this->algorithm, $this->mode);
		
		// Generate IV if required
		$this->iv = $c->generateIV();
		
		// Generate salt
		$this->salt = Crypt::GenerateSalt(32);
		
		$this->title = $c->encrypt($this->title, $password, $this->salt);
		$this->content = $c->encrypt($this->content, $password, $this->salt);
		
		$this->key = $c->encrypt(self::DECRYPT_INDICATOR, $password, $this->salt);
		
		$this->isCipher = true;
		
		return true;
	}
	
	public function decrypt($password)
	{
		if (!$this->isCipher)
		{
			return false;
		}
		
		$c = Crypt::Get($this->algorithm, $this->mode);
		$c->iv = $this->iv;
		if ($c->decrypt($this->key, $password, $this->salt) != self::DECRYPT_INDICATOR)
		{
			return $this->decryptable = false;
		}
		
		$this->title = $c->decrypt($this->title, $password, $this->salt);
		$this->content = $c->decrypt($this->content, $password, $this->salt);
		$this->decryptable = true;
		$this->isCipher = false;
		
		return true;
	}
	
	public function generate()
	{
		$html = "<div id='post-{$this->id}' class='post'>";
		$html .= $this->generateContent();
		$html .= "</div>";
		
		return $html;
	}
	
	public function generateContent()
	{
		$html = '';
		if ($this->decryptable)
		{
			$html .= "
		<h2>{$this->title}</h2>
		<small>Date: ".date(Settings::$Site['dateformat'], $this->time). "  Weather: {$this->weather}</small>
		<div class='content'>{$this->content}</div>
		<div class='meta'>Location:{$this->location} (IP:{$this->ip}) <a href='index.php?act=write&do=edit&id={$this->id}'>Edit</a></div>";
		}
		else
		{
			$html .= "
		<h2>Password Required</h2>
		<div class='content'>
			<p>Sorry, your current password can not decrypt this entry.</p>
			<p>Enter Password: <input type='password' id='passwordfield-{$this->id}' />
			<input type='button' value='Submit' onclick='getContent({$this->id});' /></p>".
			($this->hint ? "<p>Forget your password? Here's a hint: {$this->hint}</p>" : "").
		"</div>";
		}
		return $html;
	}
	
	
	
	/**
	 * Send post to server
	 
	 * @return int ID number of post just sent
	 */
	public function send()
	{
		if (!$this->isCipher)
		{
			throw new Exception("Hey, did you encrypt the post?");
		}
		$db = Database::Get();
		if (!$this->id)
		{
			$stmt = $db->prepare("INSERT INTO `pl_posts` (`title`,`content`,`time`,`weather`,`location`,`ip`,`key`,`salt`,`hint`,`algorithm`,`mode`,`iv`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->execute(array($this->title,$this->content,$this->time,$this->weather,$this->location,$this->ip,$this->key,$this->salt,$this->hint,$this->algorithm,$this->mode,$this->iv));
			
			return $db->lastInsertId();
		}
		else
		{
			// Edit post
			$stmt = $db->prepare("UPDATE `pl_posts` SET `title` = ?, `content` = ?, `time` = ?, `weather` = ?, `location` = ?, `key` = ?,`salt` = ?, `hint` = ?, `algorithm` = ?, `mode` = ?, `iv` = ? WHERE `id` = {$this->id}");
			$stmt->execute(array($this->title,$this->content,$this->time,$this->weather,$this->location,$this->key,$this->salt,$this->hint,$this->algorithm,$this->mode,$this->iv));
			
			return $this->id;
		}
	}
	
}
?>