<?php
namespace BookieMonster\Model;

/**
 * Class DbConnection
 *
 * @package BookieMonster\Model
 */
class DbConnection
{
    /**
     * @var PDO  $dbConnection
     */
    private $dbConnection;

    public function __construct($serverName, $dbName, $userName, $password)
    {
        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$serverName;dbname=$dbName",$userName,$password);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * returns a db connection
     *
     * @return PDO database connection
     */
    public function getDBConnection()
    {
        return $this->dbConnection;
    }
}
