<?php


namespace myClasses;


abstract class Mapper
{
    protected $pdo;
    protected $select_all_stmt;

    public function __construct()
    {
        $reg = Registry::instance();
        $this->pdo = $reg->getPdo();
    }

//    todo: тут нужно работать с коллекциями, но это дольше
    public function findAll()
    {
        $this->selectAllStmt()->execute();
        $rows = $this->selectAllStmt()->fetchAll();
        $this->selectAllStmt()->closeCursor();

        if (! is_array($rows)) {
            return null;
        }

        $objects = [];
        foreach ($rows as $row) {
            $objects[] = $this->doCreateObject($row);
        }

        return $objects;
    }

    protected function selectAllStmt()
    {
        return $this->select_all_stmt;
    }

//    abstract protected function targetClass(): string;

    abstract protected function doCreateObject(array $raw): DomainObject;
}