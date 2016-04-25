<?php
require_once 'config/Configuration.php';

abstract class Database
{
    /**
    * @return \PDO
    */
    static public function GetPDO($userName = NULL, $password = NULL)
    {
        $serverName = Configuration::ServerName;
        $databaseName = Configuration::DatabaseName;
        if (!isset($userName))
        {
            $userName = Configuration::UserName;
        }
        if (!isset($password))
        {
            $password = Configuration::Password;
        }
        
        $connectionString = "mysql:host=" . $serverName . ";dbname=" . $databaseName;
        
        $pdo = new \PDO($connectionString, $userName, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
