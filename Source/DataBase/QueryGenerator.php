<?php

namespace DataBase;

class QueryGenerator
{
    private $_query = "";

    public function Result() : string 
    {
        return $this->_query;
    }

    public function Select(array $selectable = [], string $patern = "[key]") : QueryGenerator
    {
        $selectable = array_fill_keys($selectable, 0);

        $filter = $this->GenerateFilter($selectable, $patern, ", ", "*");

        $this->_query = "SELECT $filter ";

        return $this;
    }

    public function From(string $table) : QueryGenerator
    {
        $this->_query .= "FROM ".$this->GenerateKey($table)." ";

        return $this;
    }

    public function Where(array $conditions) : QueryGenerator 
    {
        if (empty($conditions)) return $this;

        $filter = $this->GenerateFilter($conditions, "[key]=[value]", " AND ");

        $this->_query .= "WHERE $filter ";

        return $this;
    }

    public function Insert(string $table, array $keys) : QueryGenerator
    {
        $filter = $this->GenerateFilter($keys, "[key]");

        $this->_query = "INSERT INTO ".$this->GenerateKey($table)." ($filter) ";

        return $this;
    }

    public function Values(array $values) : QueryGenerator 
    {
        $filter = $this->GenerateFilter($values, "[value]");

        $this->_query .= "VALUES ($filter) ";

        return $this;
    }

    public function Update(string $table) : QueryGenerator
    {
        $this->_query = "UPDATE ".$this->GenerateKey($table)." ";

        return $this;
    }

    public function Set(array $values) : QueryGenerator
    {
        $filter = $this->GenerateFilter($values);

        $this->_query .= "SET $filter ";

        return $this;
    }

    public function Delete() : QueryGenerator
    {
        $this->_query = "DELETE ";

        return $this;
    }

    public function Limit(int $value) : QueryGenerator
    {
        $this->_query .= "LIMIT $value ";

        return $this;
    }

    public function Offset(int $value) : QueryGenerator
    {
        $this->_query .= "OFFSET $value ";

        return $this;
    }

    public function OrderBy(string $value) : QueryGenerator
    {
        $this->_query .= "ORDER BY `$value` ";

        return $this;
    }

    protected function GenerateFilter($filter = [], $patern = "[key]=[value]", $separator = ", ", $default = "") : string
    {
        if(empty($filter)) return $default;

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

    protected function GenerateValue($value) : string
    {
        if ($value[0] == "!") return str_replace("!", "", $value);

        switch (gettype($value)) 
        {
            case gettype("0"): return "'$value'";
            case gettype(0): return $value;
            case gettype(NULL): return "NULL";
            default: return $value;
        }
    }

    protected function GenerateKey($key) : string
    {
        if ($key[0] == "!") return str_replace("!", "", $key);

        return "`$key`";
    }
}