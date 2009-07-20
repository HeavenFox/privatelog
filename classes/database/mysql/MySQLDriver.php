<?php
class MySQLDriver
{
	/**
	 * SQL Queries Count
	 */
	public $queryCount = 0;
	
	/**
	 * Connection Link
	 */
	private $connection;
	
	/**
	 * Connected?
	 */
	private $connected = false;
	
	/**
	 * Result Resource
	 */
	private $result;
	
	/**
	 * Connection Param
	 */
	private $connParam;
	
	public function __construct($params)
	{
		$this->connParam = $params;
	}
	
	/*
	 * Connect MySQL Database
	 */
	public function connect()
	{
		if ( !$this->connected )
		{
			if ( !($this->connection = @mysql_connect($this->connParam['host'], $this->connParam['username'], $this->connParam['password'])) )
			{
				throw new Exception('Unable to establish database connection.', 201);
			}
			
			if ( !(@mysql_select_db($this->connParam['database'], $this->connection)) )
			{
				throw new Exception('Unable to select the database', 202);
			}
			
			// MySQL 4.1
			$this->simpleQuery("SET collation_connection = utf8_general_ci");
			$this->simpleQuery("SET NAMES utf8");
			$this->simpleQuery("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary;");
			
			// MySQL 5.0
			$this->simpleQuery("SET sql_mode=''");
			
			// Reset Query Count
			$this->queryCount = 0;
			$this->processError();
			$this->connected = true;
		}
	}
	
	/**
	 * Query Database
	 * @param string query string (use ? as param)
	 * @param string params
	 */
	public function query($q, $param = false)
	{
		if ($this->connParam['prefix'] != 'pl_')
		{
			$q = preg_replace('/`(pl_)([a-zA-Z0-9]+)`/', $this->connParam['prefix'] . '\\2', $q);
		}
		
		$paramIndex = 0;
		
		for ( $i = 0; $i < strlen($q); $i++ )
		{
			if ( $q[$i] == '?' )
			{
				$q = substr($q, 0, $i) . '\'' . mysql_real_escape_string(strval($param[$paramIndex]), $this->connection) . '\'' . substr($q, $i + 1);
				$paramIndex++;
			}
		}
		
		$this->simpleQuery($q);
	}
	
	/**
	 * Query database anyway
	 * Please note: escape your query string first
	 * @param string Query string
	 */
	public function simpleQuery($q)
	{
		$this->result = @mysql_query($q, $this->connection);
		
		// Anything unwanted happens?
		$this->processError();
		
		$this->queryCount++;
	}
	
	/**
	 * Get database result by MySQL Fetch Array
	 * @return array
	 */
	public function fetch($type = 'both')
	{
		switch ($type)
		{
		case 'assoc':
			return @mysql_fetch_array($this->result, MYSQL_ASSOC);
		case 'num':
			return @mysql_fetch_array($this->result, MYSQL_NUM);
		default:
			return @mysql_fetch_array($this->result);
		}
	}
	
	/**
	 * Get all results
	 * @return array
	 */
	public function fetchAll($type = 'both')
	{
		$matrix = array();
		while ( $r = $this->fetch($type) )
		{
			$matrix[] = $r;
		}
		return $matrix;
	}
	
	/**
	 * Get result's row num by MySQL Num Row
	 * @return int
	 */
	public function rowCount()
	{
		return @mysql_num_rows($this->result);
	}
	
	/**
	 * Get last inserted row's auto-generated ID
	 * @return int
	 */
	public function lastInsertId()
	{
		return @mysql_insert_id($this->connection);
	}
	
	/**
	 * Close Database
	 */
	public function close()
	{
		@mysql_close($this->connection);
		$this->connected = false;
	}
	
	private function processError()
	{
		if ( mysql_error() || mysql_errno() )
		{
			throw new Exception(mysql_error(), mysql_errno());
		}
	}
	
	/**
	 * destructor
	 */
	function __destruct()
	{
		$this->close();
	}
}

?>