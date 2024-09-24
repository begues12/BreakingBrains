<?php

namespace Plugins\Database;

class MySqli
{
    private $host;
    private $username;
    private $password;
    private $port;
    private $database;
    private $connection;

    public function __construct(string $host, string $username, string $password, string $port,string $database)
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port     = $port;
        $this->database = $database;
        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database, $this->port);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    public function select($table, $columns = "*", $conditions = [])
    {
        $sql = "SELECT $columns FROM $table";
        $whereClause = $this->toCondition($conditions);

        if (!empty($whereClause)) {
            $sql .= $whereClause;
        }

        $result = $this->query($sql);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function delete($table, $conditions = [])
    {
        $sql = "DELETE FROM $table";
        $whereClause = $this->toCondition($conditions);

        if (!empty($whereClause)) {
            $sql .= $whereClause;
        }

        return $this->query($sql);
    }

    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = [];

        foreach ($data as $value) {
            $values[] = "'" . $this->connection->real_escape_string($value) . "'";
        }

        $values = implode(', ', $values);
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->query($sql);
    }

    public function update($table, $data, $conditions = [])
    {
        $set = [];

        foreach ($data as $key => $value) {
            $key = $this->connection->real_escape_string($key);
            $value = "'" . $this->connection->real_escape_string($value) . "'";
            $set[] = "$key = $value";
        }

        $set = implode(', ', $set);
        $whereClause = $this->toCondition($conditions);
        $sql = "UPDATE $table SET $set";

        if (!empty($whereClause)) {
            $sql .= $whereClause;
        }

        return $this->query($sql);
    }

    public function createDatabase($database)
    {
        $sql = "CREATE DATABASE $database";
        return $this->query($sql);
    }

    public function getDatabases(): array
    {
        $sql = "SHOW DATABASES";
        $result = $this->query($sql);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getTables(string $database): array
    {
        $sql = "SHOW TABLES FROM $database";
        $result = $this->query($sql);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getColumns(string $database,string $table): array
    {
        $sql = "SHOW COLUMNS FROM $database.$table";
        $result = $this->query($sql);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    private function toCondition(Array $conditions = [])
    {
        $query = '';

        if (!empty($conditions)) {
            $query = ' WHERE ';
            $clauses = [];

            foreach ($conditions as $operator => $conditional_values) {
                foreach ($conditional_values as $column => $value) {
                    $column = $this->connection->real_escape_string(trim($column));

                    if (strpos($column, '!') === 0) {
                        $column = substr($column, 1);
                        $clauses[] = "$column $operator {$value[0]} {$value[1]}";
                    } else {
                        $value[0] = "'" . $this->connection->real_escape_string($value[0]) . "'";
                        $clauses[] = "$column $operator {$value[0]} {$value[1]}";
                    }
                }
            }

            $query .= implode(' AND ', $clauses);
        }

        return $query;
    }

    public function testConnection()
    {
        return $this->connection->ping();
    }

}
