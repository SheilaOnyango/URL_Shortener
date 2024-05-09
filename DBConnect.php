<?php

/* Database connection using PDO
*/

class DBConnect
{
    private $host = 'db'; 
    private $dbname = 'URL_shortener';
    private $user = 'root';
    private $pass = 'lionPass';

    public function connect()
    {
        try {
            //Establish database connection
            $conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            // Display detailed error message
            echo "Database Error: " . $e->getMessage();
            // Stop script execution
            die();
        }
    }
}

?>

