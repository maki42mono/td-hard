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
}