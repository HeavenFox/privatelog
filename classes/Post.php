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
	public $hint;
	
	public $decryptable;
	
	public $isCipher = false;
	
	public function fetch($id)
	{
		$db = Database::Get();
		
		$db->query("SELECT * FROM `pl_posts` WHERE id = {$id}");
		
		if ($db->rowCount())
		{
			$this->fill($db->fetch(),true);
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
		$this->hint = $params['hint'];
		$this->ip = $params['ip'];
		$this->algorithm = $params['algorithm'];
		$this->mode = $params['mode'];
		$this->iv = $params['iv'];
		
		$this->isCipher = $isCipher;
	}
	
	public function decrypt($key)
	{
		if (!$this->isCipher)
		{
			return false;
		}
		if (sha1($key) != $this->key)
		{
			return $this->decryptable = false;
		}
		
		$c = Crypt::Get();
		
		$this->title = $c->decrypt($this->title, $key);
		$this->content = $c->decrypt($this->content, $key);
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
		<small>Date: ".date('l, M n, Y g:i:s A', $this->time). "  Weather: {$this->weather}</small>
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
	
	public function encrypt($key)
	{
		if ($this->isCipher)
		{
			return;
		}
		
		$c = Crypt::Get($this->algorithm, $this->mode);
		
		$iv = null;
		if ($c->ivRequired())
		{
			$iv = $c->getIv();
		}
		
		$this->title = $c->encrypt($this->title, $key);
		$this->content = $c->encrypt($this->content, $key);
		
		$this->key = sha1($key);
		
		$this->isCipher = true;
	}
	
	/**
	 * Send post to server
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
			$db->query("INSERT INTO `pl_posts` (`title`,`content`,`time`,`weather`,`location`,`ip`,`key`,`hint`,`algorithm`,`mode`) VALUES (?,?,?,?,?,?,?,?,?,?)",array($this->title,$this->content,$this->time,$this->weather,$this->location,$this->ip,$this->key,$this->hint,$this->algorithm,$this->mode));
			return $db->lastInsertId();
		}
		else
		{
			// Edit post
			$db->query("UPDATE `pl_posts` SET `title` = ?, `content` = ?, `time` = ?, `weather` = ?, `location` = ?, `key` = ?, `hint` = ? `algorithm` = ?, `mode` = ? WHERE `id` = {$this->id}", array($this->title,$this->content,$this->time,$this->weather,$this->location,$this->key,$this->hint,$this->algorithm,$this->mode));
			return $this->id;
		}
	}
	
}
?>