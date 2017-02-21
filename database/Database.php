<?php
include_once './help_functions.php';

class Database
{
    // Connection info
    private $_dsn = 'mysql:dbname=adss;host=127.0.0.1';
    private $_username = 'root';
    private $_password = '';
    protected $_query;
    protected $_dbh;

    // constructor for creating a connection to the database
    public function __construct()
    {
        try {
            $this->_dbh = new PDO($this->_dsn,$this->_username,$this->_password);
        } catch (PDOException $exception) {
            echo $exception -> getMessage();
            exit ;
        }
    }

    public function __destruct()
    {
        // close connection
        $this->_dbh = NULL;
    }

    /**
     * execute the query and return result
     * @param String $q - the Query
     */
    public function createQuery($q)
    {
        $this->_query = $q;
        $stmt = $this->_dbh->prepare($this->_query);
        $stmt->execute();

        // get results and limit it
        $result = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function lastInsertId()
    {
        return $this->_dbh->lastInsertId();
    }
}
