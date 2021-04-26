<?php


namespace myClasses;


abstract class DomainObject
{
    public $attributes = [];
    private $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    protected static function findAllByMapper(Mapper $mapper): array
    {
        return $mapper->findAll();
    }

    public function save(): bool
    {
        $mapper = $this->targetMapper();
        if (isset($this->id)) {
            $mapper->update($this);
        } else {
            $mapper->save($this);
        }

        return true;
    }

//    todo: переделать в ахивацию
    public function delete(): bool
    {
        $mapper = $this->targetMapper();
        if (! isset($this->id)) {
            return false;
        }

        return $mapper->delete($this);

    }

    protected static function getTotalCountByMapper(Mapper $mapper): int
    {
        return $mapper->getTotalCount();
    }

    abstract protected static function targetMapper(): Mapper;

    abstract public static function findAll(): array;

    abstract public static function getTotalCount(): int;
}