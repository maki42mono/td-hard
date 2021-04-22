<?php


namespace myClasses;


abstract class Mapper
{
    protected $pdo;
    protected $select_all_stmt;
    protected $update_stmt;

    public function __construct()
    {
        $reg = Registry::instance();
        $this->pdo = $reg->getPdo();
//        $this->pdo->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );
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
            "UPDATE news SET {$update_values} WHERE id={$object->getId()}"
        );

        $res = $this->updateStmt()->execute();

        $this->updateStmt()->debugDumpParams();

    }

    protected function updateStmt()
    {
        return $this->update_stmt;
    }

//    abstract protected function targetClass(): string;

    abstract protected function doCreateObject(array $raw): DomainObject;
}