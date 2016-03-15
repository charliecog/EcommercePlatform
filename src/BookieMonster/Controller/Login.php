<?php

namespace BookieMonster\Controller;

/**
 * Class Login
 *
 * @package BookieMonster\Controller
 */
class Login
{
    /**
     * @var string  $userName          name supplied by user
     * @var string  $userPassword      password supplied by user
     * @var PDO     $dbConnection      database connection
     * @var string  $dbHashedPassword  hashed password from the database
     */

    private $userName;
    private $userPassword;
    private $dbConnection;
    private $dbHashedPassword;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * sets users credentials from the POST data entered in login form
     *
     * @param string $userName string containing username information
     * @param string $userPassword string containing password information
     */
    public function setUserCredentials($userName, $userPassword)
    {
        $this->userName = $userName;
        $this->userPassword = $userPassword;
    }

    /**
     * verifies users credentials against whats already in the database
     *
     */
    public function verifyLogin()
    {
        $queryString = 'SELECT `password_hash` FROM `admin_user` WHERE `username` = :userName;';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':userName', $this->userName);
            $stmt->execute();
            $dbHashedPassword = $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            $dbHashedPassword = ['error' => 'Error'];
        }
        $this->dbHashedPassword = $dbHashedPassword;
        if(password_verify($this->userPassword, $dbHashedPassword["password_hash"])) {
            $this->setSessionCredentials();
        }
        else {
        }
    }

    /**
     * sets session credentials to be used to check if logged in on each page
     *
     */
    private function setSessionCredentials()
    {
        if(isset($this->dbHashedPassword)){
            session_regenerate_id();
            $_SESSION['user'] = $this->userName;
            $_SESSION['loggedIn'] = true;
        }
    }
}
