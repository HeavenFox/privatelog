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
	
	public $key;
	
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
		$this->ip = $params['ip'];
		
		$this->isCipher = $isCipher;
	}
	
	public function decrypt($key)
	{
		if (!$this->isCipher)
		{
			return;
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
			<input type='button' value='Submit' onclick='getContent({$this->id});' /></p>
		</div>";
		}
		return $html;
	}
	
	/**
	 * @todo
	 */
	public function encrypt($key)
	{
		if ($this->isCipher)
		{
			return;
		}
		$c = Crypt::Get();
		
		$this->title = $c->encrypt($this->title, $key);
		$this->content = $c->encrypt($this->content, $key);
		
		$this->isCipher = true;
	}
	
	/**
	 * @todo
	 */
	public function post()
	{
		
	}
	
}
?>