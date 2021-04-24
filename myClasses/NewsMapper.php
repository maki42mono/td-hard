<?php


namespace myClasses;


class NewsMapper extends Mapper
{

    protected function doCreateObject(array $raw): DomainObject
    {
        $object = new NewsModel($raw);
        return $object;
    }

    protected function targetTable(): string
    {
        return "news";
    }
}