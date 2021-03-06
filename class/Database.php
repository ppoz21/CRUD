<?php

namespace App\class;

use PDO;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $connection = $this->connect();
        if (gettype($connection) === 'string')
        {
            die($connection);
        }
    }

    public function connect(): bool | string
    {
        $dbuser = 'ppoz21';
        $dbpass = 'P@ssw0rd';
        try {
            $this->connection = new PDO('pgsql:host=localhost;dbname=crud', $dbuser, $dbpass);
            return true;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function createTable(string $tablename, array $fields): bool | string
    {
        $sql = "CREATE TABLE IF NOT EXISTS " . $tablename . "(id serial primary key, ";

        foreach ($fields as $field)
        {
            // 0 - name, 1 - type, 2 - nullable?
            $sql .= "$field[0] $field[1] $field[2]";
            if (next($fields) == true) $sql .= ',';
        }

        $sql .= ");";

        try {
            $this->connection->query($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }

    }

    public function listTables(): array | string
    {
        $sql = "SELECT table_name 
            FROM information_schema.tables
            WHERE table_schema = 'public'
            ORDER BY table_name;";

        try
        {
            $result = $this->connection->query($sql);
            $arr = [];

            foreach ($result as $row)
            {
                $sql1 = "SELECT count(*) from $row[0]";
                $result = $this->connection->query($sql1);
                $tempCount = 0;
                foreach ($result as $row2)
                {
                    $tempCount = $row2[0];
                }
                $temp = [$row[0], $tempCount];
                array_push($arr, $temp);
            }
            return $arr;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function insertInto(string $tablename, array $values): bool | string
    {
        $sql = "INSERT INTO $tablename VALUES (";
        $sql .= 'default,';

        foreach ($values as $value)
        {

            if (is_numeric($value))
                $sql .= $value;
            else
                $sql .= "'$value'";
            if (next($values) == true) $sql .= ', ';
        }

        $sql .= ");";

        try
        {
            $this ->connection->query($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function updateTable( string $tablename, array $values, int $id): bool | string
    {
        $sql = "UPDATE $tablename SET ";

        foreach ($values as $k => $v)
        {
            if (is_numeric($v))
                $sql .= "$k = $v";
            else
                $sql .= "$k = '$v'";

            if (next($values) == true) $sql .= ', ';
        }

        $sql .= " WHERE id = $id;";

        try
        {
            $this ->connection->query($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            return $sql;
        }
    }

    public function deleteOnce( string $tablename, int $id): bool | string
    {
        $sql = "DELETE FROM $tablename WHERE id = $id;";

        try
        {
            $this ->connection->query($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function deleteRange(string $tablename, int $min, int $max): bool | string
    {
        $sql = "DELETE FROM $tablename WHERE id BETWEEN $min AND $max";

        try
        {
            $this ->connection->query($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function dropTable(string $tablename): bool | string
    {
        $sql = "DROP TABLE $tablename;";


        try
        {
            $this ->connection->query($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function selectFrom(string $tablename): array | string
    {
        $sql = "SELECT *
            FROM $tablename;";

        try
        {
            $result = $this->connection->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function selectFromWhereId(string $tablename, int $id): array | string
    {
        $sql = "SELECT *
            FROM $tablename 
            WHERE id = $id;";

        try
        {
            $result = $this->connection->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function getCols(string $tablename): array | string
    {
        $sql = "select column_name,data_type 
                from information_schema.columns 
                where table_name = '$tablename';";

        try
        {
            $result = $this->connection->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }
    }
}
