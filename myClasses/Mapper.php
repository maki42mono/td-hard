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

//    todo: упростить
    public function update(DomainObject $object): bool
    {
//        todo: обработать ошибку
        if (! is_array($object->attributes)) {
            throw new \Exception();
        }
        
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
        


        $this->update_stmt = $this->pdo->prepare(
            "UPDATE {$this->table_name} SET {$update_values} WHERE id={$object->getId()}"
        );

        return $this->updateStmt()->execute();
    }

    public function getTotalCount(): int
    {
//        todo: переделать, когда перейдем к архивации
        $sth = $this->pdo
            ->prepare("SELECT COUNT(1) FROM {$this->table_name}");
        $sth->execute();
        $count = $sth->fetchColumn();
        $sth->closeCursor();
        return $count;
    }

    public function save(DomainObject $object): bool
    {
    //        todo: обработать ошибку
        if (! is_array($object->attributes)) {
            throw new \Exception();
        }

        $sql_value_names = "";
        $sql_new_values = "";
        $is_first = true;
        $delim = "";
        foreach ($object->attributes as $key => $value) {
            if (isset($value) && !is_null($value) && $key != "id") {
                $sql_value_names = $delim . $key;
                $sql_new_values .= "{$delim}'{$value}'";
                if ($is_first) {
                    $is_first = false;
                    $delim = ", ";
                }
            }
        }

        $sth = $this->pdo
            ->prepare("INSERT INTO {$this->table_name} ({$sql_value_names}) VALUES ({$sql_new_values})");
        $res = $sth->execute();
        $object->setId($this->pdo->lastInsertId());

//        $sth->debugDumpParams();

        return $res;
    }

    public function delete(DomainObject $object): bool
    {
        if ($object->getId() == null) {
            throw new \Exception();
        }

        $sth = $this->pdo
            ->prepare("DELETE FROM {$this->table_name} WHERE id={$object->getId()}");
        $res = $sth->execute();

        return $res;

    }

    protected function updateStmt()
    {
        return $this->update_stmt;
    }

    abstract protected function doCreateObject(array $raw): DomainObject;

    abstract protected function targetTable(): string;
}