<?php

namespace DataBase;

use PDO;
use Exception;
use const Config\DB_NAME;

class DataBaseTable
{
    protected $_handler;
    protected $_name;

    public function __construct($name, $connection)
    {
        $this->_handler = $connection;

        $this->SetTableName($name);
    }

    public function SetTableName($value)
    {
        if ($this->IsTableExists($value))
        {
          $this->_name = $value;
        }
        else throw new Exception("Table $this->_name is not exists");
    }

    public function IsTableExists($name)
    {
        $query = "SELECT TABLE_NAME AS `table` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DB_NAME."'";

        $tables = $this->ExecuteAndFetch($query);

        foreach ($tables as $value) 
        {
            if( $value["table"] == $name)
            {
                return true;
            }
        }

        return false;
    }

    public function GetId($filter = [])
    {
        $query = $this->GenerateQuery("SELECT Id FROM ".$this->_name.
                                $this->TryInsertWhere($filter), 
                                $filter, "[key]=[value]", " AND ", " LIMIT 1");

        return intval($this->ExecuteAndFetch($query)[0]["Id"]);
    }

    public function GetRow($id)
    {
        $query = "SELECT * FROM ".$this->_name." WHERE Id = $id";
        return $this->ExecuteAndFetch($query);
    }

    public function GetRows($filter = [], $orderBy = "Id", $count = 100, $offset = 0)
    {
        $query = $this->GenerateQuery("SELECT * FROM ".$this->_name. 
                            $this->TryInsertWhere($filter), 
                            $filter, "[key]=[value]", " AND ", 
                            " ORDER BY $orderBy LIMIT $count OFFSET $offset");
                            
        return $this->ExecuteAndFetch($query);
    }

    public function Insert($data = [])
    {
        $query = "INSERT INTO ".$this->_name."(";
        $query .= $this->GenerateFilter($data, "[key]", ", ");
        $query .= ") VALUES(";
        $query .= $this->GenerateFilter($data, "[value]", ", ");
        $query.= ")";
        
        return $this->Execute($query);
    }

    public function Update($id, $data = [])
    {
        $query = $this->GenerateQuery("UPDATE ".$this->_name." SET",
                        $data, "[key]=[value]", ", ", " WHERE Id = $id");

        return $this->Execute($query);
    }

    public function Delete($id)
    {
        $query = "DELETE FROM ".$this->_name." WHERE Id = $id";
        return $this->Execute($query);
    }

    public function GetRowsCount($filter = [])
    {
        $query = $this->GenerateQuery("SELECT COUNT(*) as count FROM ".$this->_name.
                        $this->TryInsertWhere($filter),
                        $filter, "[key]=[value]", ", ", "");

        return intval($this->ExecuteAndFetch($query)[0]["count"]);
    }

    public function Execute($query)
    {
        $sth = $this->_handler->prepare($query);
        $sth->execute();
        return $sth->rowCount();
    }

    public function ExecuteAndFetch($query)
    {
        $sth = $this->_handler->query($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function GenerateQuery($base, $filter, $patern, $separator, $end)
    {
        $query = $base." ";
        $query .= $this->GenerateFilter($filter, $patern, $separator);
        $query .= $end;
        return $query;
    }

    protected function GenerateFilter($filter = [], $patern, $separator)
    {
        if(count($filter) == 0) return "";

        $result = "";

        $counter = 1;
        foreach ($filter as $key => $value) 
        {
            $replaced = str_replace(["[key]", "[value]"], [$this->GenerateKey($key), $this->GenerateValue($value) ], $patern);

            $result .= $replaced;

            if ($counter != count($filter))
            {
                $result .= $separator;
                $counter++;
            }
        }

        return $result;
    }

    protected function GenerateValue($value)
    {
        switch (gettype($value)) 
        {
            case gettype("0"): return "'$value'";
            case gettype(0): return $value;
            case gettype(NULL): return "null";
            default: return $value;
        }
    }

    protected function GenerateKey($key)
    {
        return "`$key`";
    }

    protected function TryInsertWhere($filter)
    {
        return (count($filter) > 0 ? " WHERE" : "");
    }
}

?>