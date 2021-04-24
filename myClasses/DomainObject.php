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

    protected static function findAllByMapper(Mapper $mapper): array
    {
        return $mapper->findAll();
    }

    public function save()
    {
        $mapper = $this->targetMapper();
        $mapper->update($this);
    }

    abstract protected static function targetMapper(): Mapper;

    abstract public static function findAll(): array;
}