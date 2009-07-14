<?php
class PostSet
{
	public $posts;
	
	public $prev = false;
	public $next = false;
	public $page;
	
	public function fetch($conditions)
	{
		$db = Database::Get();
		
		$query = 'SELECT * FROM `pl_posts` WHERE';
		
		$attr = '';
		
		// ID?
		if (isset($conditions['id']))
		{
			$query .= ' id = '. $conditions['id'];
		}
		else
		{
			// Date & Time
			// @todo
			
			// Page
			$page = $this->page = $conditions['page'] ? $conditions['page'] : 1;
			if ($page != 1)
			{
				$this->prev = true;
			}
			
			// Check if other pages exist
			$db->query('SELECT COUNT(*) FROM `pl_posts` WHERE'. $attr);
			$count = $db->fetch();
			$count = $count[0];
			if ($count > $page * Settings::$Site['entries'])
			{
				$this->next = true;
			}
			
			// Sort by
			// @todo
			$attr .= 'ORDER BY time DESC'
			
			$query .= $attr;
			$query .= ' LIMIT '.($page-1)*Settings::$Site['entries'].','.Settings::$Site['entries'];
		}
		
		$db->query($query);
		
		while ($entry = $db->fetch('assoc'))
		{
			$postObj = new Post;
			$postObj->fill($entry);
			$this->posts[] = $postObj;
		}
	}
	
	public function generate()
	{
		$html = '';
		
		// Generate posts html
		foreach ($this->posts as $v)
		{
			$html .= $v->generate();
			$html .= "\n";
		}
		
		// Generate Next - Prev link
		$html .= '<div id="nav">';
		if ($this->prev)
		{
			$prevPage = $this->page - 1;
			$html .= "<div id='prev'><a href='index.php?page={$prevPage}'>Newer Posts</a></div>";
		}
		
		if ($this->next)
		{
			$nextPage = $this->page + 1;
			$html .= "<div id='prev'><a href='index.php?page={$nextPage}'>Plder Posts</a></div>";
		}
		$html .= '</div>'
		
		return $html;
	}
}
?>