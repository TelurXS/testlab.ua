<?php

namespace DataBase;

use PDO;
use Exception;

use const Config\DB_NAME;

const ID = "Id";

class DataBaseTable
{
    protected $_handler;
    protected $_name;

    public function __construct(string $name, PDO $connection)
    {
        $this->_handler = $connection;

        $this->SetTableName($name);
    }

    public function SetTableName(string $value)
    {
        if ($this->IsTableExists($value))
        {
          $this->_name = $value;
        }
        else throw new Exception("Table $this->_name is not exists");
    }

    public function IsTableExists(string $name)
    {
        $query = (new QueryGenerator)->
            Select(["!`TABLE_NAME` AS `table`"])->
            From("!INFORMATION_SCHEMA.TABLES")->
            Where(["TABLE_SCHEMA"=>DB_NAME])->Result();

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

    public function GetId(array $filter = []) : int
    {
        $query = (new QueryGenerator)->
            Select([ID])->From($this->_name)->
            Where($filter)->Limit(1)->Result();

        return intval($this->ExecuteAndFetch($query)[0][ID]);
    }

    public function GetRow(int $id) : array
    {
        $query = (new QueryGenerator)->
            Select()->From($this->_name)->
            Where([ID => $id])->Limit(1)->Result();

        return $this->ExecuteAndFetch($query);
    }

    public function GetRows(array $filter = [], string $orderBy = ID, int $count = 100, int $offset = 0) : array
    {                 
        $query = (new QueryGenerator)->
            Select()->From($this->_name)->Where($filter)->
            OrderBy($orderBy)->Limit($count)->
            Offset($offset)->Result();

        
        return $this->ExecuteAndFetch($query);
    }

    public function Insert(array $data = []) : int
    {
        $query = (new QueryGenerator)->
            Insert($this->_name, $data)->Values($data)->Result();
        
        return $this->Execute($query);
    }

    public function Update(int $id, array $data = []) : int
    {
        $query = (new QueryGenerator)->
            Update($this->_name)->Set($data)->
            Where([ID=>$id])->Result();

        return $this->Execute($query);
    }

    public function Delete(int $id) : int
    {
        $query = (new QueryGenerator)->
            Delete()->From($this->_name)->
            Where([ID=>$id])->Result();

        return $this->Execute($query);
    }

    public function GetRowsCount(array $filter = []) : int
    {
        $query = (new QueryGenerator)->
            Select(["!COUNT(*) as count"])->From($this->_name)->
            Where($filter)->Result();

        return intval($this->ExecuteAndFetch($query)[0]["count"]);
    }

    public function Execute(string $query) : int
    {
        $sth = $this->_handler->prepare($query);
        $sth->execute();
        return $sth->rowCount();
    }

    public function ExecuteAndFetch(string $query) : array
    {
        $sth = $this->_handler->query($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>