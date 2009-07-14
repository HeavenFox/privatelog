<?php
class Post
{
	public $id;
	public $title;
	public $content;
	public $weather;
	public $location;
	public $ip;
	
	public $key;
	
	public $decryptable;
	
	public function fill($params)
	{
		$this->id = $params['id'];
		$this->title = $params['title'];
		$this->content = $params['content'];
		$this->weather = $params['weather'];
		$this->location = $params['location'];
		$this->key = $params['key'];
		$this->ip = $params['ip'];
	}
	
	public function decrypt($key = null)
	{
		if (!$key)
		{
			$key = Session::Get('password');
		}
		
		if (sha1($key) != $this->key)
		{
			return $this->decryptable = false;
		}
		
		$c = Crypt::Get();
		
		$this->title = $c->decrypt($this->title, $key);
		$this->content = $c->decrypt($this->content, $key);
	}
	
	public function generate()
	{
		$html = "<div id='post-{$this->id}' class='post'>";
		if ($this->decryptable)
		{
			$html .= "
		<h1 class='title'>{$this->title}</h1>
		<div class='content'>{$this->content}</div>";
		}
		else
		{
			$html .= "
		<hi class='title'>Password Required</h1>
		<div class='content'>
			<p>Sorry, your current password can not decrypt this entry.</p>
			<p>Enter Password: <input type='password' id='passwordfield-{$this->id}' />
			<input type='button' value='Submit' onclick='getContent({$this->id});' /></p>
		</div>";
		}
		$html .= "</div>";
		
		return $html;
	}
	
	/**
	 * @todo
	 */
	public function encrypt($key = null)
	{
		
	}
	
	/**
	 * @todo
	 */
	public function post()
	{
		
	}
	
}
?>