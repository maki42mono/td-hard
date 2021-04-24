<?php


namespace myClasses;


abstract class Mapper
{
    private $pdo;
    private $select_all_stmt;
    private $update_stmt;
    private $table_name;

    public function __construct()
    {
        $reg = Registry::instance();
        $this->pdo = $reg->getPdo();
        $this->table_name = $this->targetTable();
    }

//      todo: тут нужно работать с коллекциями, но это дольше
//      todo: упростить!
    public function findAll()
    {
        $this->select_all_stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table_name}"
        );

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

    public function update(DomainObject $object)
    {
        if (is_array($object->attributes)) {
            $update_values = "";
            $is_first = true;
            $delim = "";
            foreach ($object->attributes as $key => $value) {
                if (isset($value) && !is_null($value) && $key != "id") {
                    $update_values .= "{$delim}{$key} = '$value'";
                    if ($is_first) {
                        $is_first = false;
                        $delim = ", ";
                    }
                }
            }
        }


        $this->update_stmt = $this->pdo->prepare(
            "UPDATE {$this->table_name} SET {$update_values} WHERE id={$object->getId()}"
        );

        $res = $this->updateStmt()->execute();

        $this->updateStmt()->debugDumpParams();

    }

    protected function updateStmt()
    {
        return $this->update_stmt;
    }

    abstract protected function doCreateObject(array $raw): DomainObject;

    abstract protected function targetTable(): string;
}