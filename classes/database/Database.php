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
            self::$connection->connect();
        }
        return self::$connection;
    }
    
    private static function CreateConnection($params)
    {
        switch($params['driver'])
        {
        case 'mysql':
            require_once ROOT. 'classes/database/mysql/MySQLDriver.php';
            
            return new MySQLDriver($params);
            
        default:
            throw new Exception('Invalid Database Driver!');
        }
    }
}
?>