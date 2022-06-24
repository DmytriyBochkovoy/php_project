<?php

namespace It20Academy\App\Models;

use It20Academy\App\Core\Db;
use It20Academy\App\Service\QueryBuilder;

class Model
{
    protected string $table;

    protected array $fillable = [];

    public array $relations;

    public function fill($data): void
    {
        foreach ($data as $key => $item) {
            $this->{$key} = $item;
        }
    }

    public function hasParent($model, $relationName, $column, $wheres = null) {
        if(isset($this->relations[$relationName])) {
            return $this->relations[$relationName];
        }
        $instance = new $model();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->select('*')
            ->from($instance->table)
            ->where('id', '=', $this->{$column});

        if ($wheres) {
            $wheres($queryBuilder);
        }

        $dbh = (new Db())->getHandler();
        $statement = $dbh->query($queryBuilder->getQuery());

        $data = $statement->fetchAll()[0];

        if (empty($data)) {
            return  null;
        }

        $instance->fill($data);

        $this->relations[$relationName] = $instance;

        return $instance;
    }

    public function hasMany($model, $relationName, $column, $wheres = null) {
        if(isset($this->relations[$relationName])) {
            return $this->relations[$relationName];
        }
        $instance = new $model();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->select('*')
            ->from($instance->table)
            ->where($column, '=', $this->id);

        if ($wheres) {
            $wheres($queryBuilder);
        }

        $dbh = (new Db())->getHandler();
        $statement = $dbh->query($queryBuilder->getQuery());
        $data = $statement->fetchAll();

        $instances = array_map(function ($item) use ($model) {
            $instance = new $model();
            $instance->fill($item);

            return $instance;
        }, $data);

        $this->relations[$relationName] = $instances;

        return $instances;
    }

    public function hasChild($model, $relationName, $column, $wheres = null) {
        if(isset($this->relations[$relationName])) {
            return $this->relations[$relationName];
        }
        $instance = new $model();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->select('*')
            ->from($instance->table)
            ->where($column, '=', $this->id);

        if ($wheres) {
            $wheres($queryBuilder);
        }

        $dbh = (new Db())->getHandler();
        $statement = $dbh->query($queryBuilder->getQuery());

        $data = $statement->fetchAll()[0] ?? null;

        if (empty($data)) {
            return null;
        }

        $instance->fill($data);

        $this->relations[$relationName] = $instance;

        return $instance;
    }

//    public function attachCilde(array $ids) {
//
//    }

    public function toMany($model, $relationName, $column1, $value, $column2, $wheres = null) {
        if(isset($this->relations[$relationName])) {
            return $this->relations[$relationName];
        }
        $instance = new $model();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->select('fuel_types.*')
            ->from($instance->table1)
            ->join($instance->table2, $column1, '=', $instance->table1 .= ".{$value}")
            ->where($column2, '=', $this->id);


        if ($wheres) {
            $wheres($queryBuilder);
        }

        $dbh = (new Db())->getHandler();
        $statement = $dbh->query($queryBuilder->getQuery());
        $data = $statement->fetchAll();

        $instances = array_map(function ($item) use ($model) {
            $instance = new $model();
            $instance->fill($item);

            return $instance;
        }, $data);

        $this->relations[$relationName] = $instances;

        return $instances;
    }

    public function create(array $data) {

        $this->fill($data);
        $queryBuilder = new QueryBuilder();
        $queryBuilder->insert()->into($this->table, $data);

        dump($queryBuilder->getQuery());

        $dbh = (new Db())->getHandler();
        $insertCar =  $dbh->query($queryBuilder->getQuery());
//        if (in_array( , $this->fillable)) {
//
//        }
    }

//    public function update(array $data) {
//
//        $this->fill($data);
//        $queryBuilder = new QueryBuilder();
//        $queryBuilder->update($this->table, $data)->;
//
//        dump($queryBuilder->getQuery());
//
//        $dbh = (new Db())->getHandler();
//        $insertCar =  $dbh->query($queryBuilder->getQuery());
//        if (in_array( , $this->fillable)) {
//
//        }
//    }
}