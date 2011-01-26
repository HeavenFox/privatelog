<?php
class Database
{
    private static $connection = null;
    
    /**
     * Get a database connection object
     *
     * @return object database connection
     */
    public static function Get()
    {
        if (self::$connection == null)
        {
            self::$connection = self::CreateConnection(Settings::$DB);
        }
        return self::$connection;
    }
    
    private static function CreateConnection($params)
    {
        switch($params['driver'])
        {
		case 'mysql':
			return new PDO('mysql:host='.$params['host'].';dbname='.$params['database'],$params['username'],$params['password']);
        default:
            throw new Exception('Invalid Database Driver!');
        }
    }
}
?>