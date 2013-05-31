<?php

class DB
{

    public $connection = null;

    public function getConfig(){
        return (array)json_decode(file_get_contents('db/db.json'));
    }

    public function setupConnection()
    {
        $dbConfig = $this->getConfig();
        $this->connection = new mysqli(
            $dbConfig['host'],
            $dbConfig['user'],
            $dbConfig['password'],
            $dbConfig['db_name']
        );
        if (mysqli_connect_errno()) {
            throw new Exception("Connect failed: %s\n", mysqli_connect_error());
        }
    }

    public function query($query)
    {
        if (!$this->connection) {
            $this->setupConnection();
        }
        if (trim($query)) {
            $mysqli_result = $this->connection->query($query);
            if ($mysqli_result) {
                $results_array = array();
                if (is_object($mysqli_result)) {
                    while ($row = $mysqli_result->fetch_assoc()) {
                        $results_array[$row['id']] = $row;
                    }
                }
                return $results_array;
            } else {
                throw new Exception($this->connection->error);
            }
        }
    }


    public function installApp()
    {
        if (!$this->connection) {
            $this->setupConnection();
        }
        $installSQL = explode(";", file_get_contents('db/db_setup/create_tables.sql')); //
        foreach ($installSQL as $installQuery) {
            $this->query($installQuery);
        }
        $testDataSQL = explode(";", file_get_contents('db/db_setup/test_data.sql')); //
        foreach ($testDataSQL as $testDataQuery) {
            $this->query($testDataQuery);
        }

    }

}
