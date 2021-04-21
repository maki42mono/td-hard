<?php


namespace myClasses;


class NewsMapper extends Mapper
{
    protected $select_all_stmt;

    public function __construct()
    {
        parent::__construct();

        $this->select_all_stmt = $this->pdo->prepare(
            "SELECT * FROM news"
        );

        $this->update_stmt = $this->pdo->prepare(
            "UPDATE news SET ? WHERE id=?"
        );
    }

    protected function doCreateObject(array $raw): DomainObject
    {
        $object = new NewsModel($raw);
        return $object;
    }
}