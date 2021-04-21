<?php


namespace myClasses;


class NewsModel
{
    public $attributes = [];
    public const ATTR_PARAMS = [
        "id" => [
            "label" => "ID",
            "db_column_name" => "id",
    	],
        "title" => [
            "label" => "Заголовок",
            "db_column_name" => "title",
    	],
        "descriptionShort" => [
            "label" => "Краткое описание",
            "db_column_name" => "description_short",
    	],
        "descriptionLong" => [
            "label" => "Основное описание",
            "db_column_name" => "description_long",
    	],
        "publishedDate" => [
            "label" => "Дата публикации",
            "db_column_name" => "published_date",
    	],
        "image" => [
            "label" => "Картинка",
            "db_column_name" => "img_name",
    	],
        "isDraft" => [
            "label" => "Черновик",
            "db_column_name" => "flag_draft",
    	],
        "created" => [
            "label" => "Дата добавления",
            "db_column_name" => "created",
    	],
        "updated" => [
            "label" => "Дата изменения",
            "db_column_name" => "updated",
    	],
    ];

    public function __construct($attributes = [])
    {
        if (isset($attributes)) {
            foreach ($attributes as $key => $value) {
                if (isset(self::ATTR_PARAMS[$key])) {
                    $this->attributes[$key] = $value;
                }
            }
        }
    }
}