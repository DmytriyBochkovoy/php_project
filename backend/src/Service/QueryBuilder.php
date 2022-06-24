<?php

namespace It20Academy\App\Service;


class QueryBuilder
{
    public string $query = '';

//    public function where($column, $value, $operator): static
//    {
//        $this->query .= " and {$column} {$operator} {$value}";
//
//        return $this;
//    }

    public function reset() {
        $this->query = '';
    }

    public function where($column, $operator, $value): static
    {
        $pos = strripos($this->query, 'where');

        if (!$pos) {
            $this->query .= "where ";
        }
        $this->query .= "{$column} {$operator} '{$value}'";

        return $this;
    }

    public function and(): static
    {
        $this->query .= " and ";

        return $this;
    }

    public function semicolon(): static
    {
        $this->query .= "; ";

        return $this;
    }

    public function or(): static
    {
        $this->query .= " or ";

        return $this;
    }

//    public function orWhere($column, $value, $operator): static
//    {
//        $this->query .= " or {$column} {$operator} {$value}";
//
//        return $this;
//    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function groupClosure($closure): static
    {
        $query = $closure(new QueryBuilder());

        $query = str_replace('where', '', $query);

        $this->query .= "({$query})";

        return $this;
    }

    public function select(string $columns): static
    {
        $this->query .= "select {$columns} ";

        return $this;
    }

    public function from(string $table): static
    {
        $this->query .= "from {$table} ";

        return $this;
    }

    public function join(string $table, string $column1, string $operator, string $column2): static
    {
        $this->query .= "join {$table} on {$column1} {$operator} {$column2} ";

        return $this;
    }

    public function insert()
    {
        $this->query .= "insert ";

        return $this;
    }

    public  function into(string $table, array $data)
    {
        $stringColumns = '';

        foreach (array_keys($data) as $key) {
            $stringColumns .= "{$key}, ";
        }

        $stringColumns = substr($stringColumns, 0, -2);

        $this->query .= "into {$table}({$stringColumns}) ";

        $stringValues = '';

        foreach ($data as $value) {
            $stringValues .= "'{$value}', ";
        }

        $stringValues = substr($stringValues, 0, -2);

        $this->query .= "values ({$stringValues})";

        return $this;
    }

    public function update($table, $data)
    {
        $this->query .= "update {$table} set ";

        foreach ($data as $key => $value) {
            $this->query .= "$key='{$value}', ";
        }

        $this->query = substr($this->query,0,-2);

        return $this;
    }

    public function whereIn($column, $values): static
    {
        $pos = strripos($this->query, 'where');

        if (!$pos) {
            $this->query .= "where ";
        }

        $stringValue =  implode(', ', $values);

        $this->query .= "{$column} in ({$stringValue})";

        return $this;
    }


    //SELECT fuel_types.* FROM `car_fuel_types` INNER JOIN fuel_types ON fuel_types.id = car_fuel_types.id WHERE car_fuel_types.car_id = 1;
}