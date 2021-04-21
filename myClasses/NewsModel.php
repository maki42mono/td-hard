<?php


namespace myClasses;


class NewsModel extends DomainObject
{
    public $attributes = [];
    public const ATTR_PARAMS = [
        "id" => [
            "label" => "ID",
            "front_name" => "id",
        ],
        "title" => [
            "label" => "Заголовок",
            "front_name" => "title",
        ],
        "description_short" => [
            "label" => "Краткое описание",
            "front_name" => "descriptionShort",
        ],
        "description_long" => [
            "label" => "Основное описание",
            "front_name" => "descriptionLong",
        ],
        "published_date" => [
            "label" => "Дата публикации",
            "front_name" => "publishedDate",
        ],
        "img_name" => [
            "label" => "Картинка",
            "front_name" => "image",
        ],
        "flag_draft" => [
            "label" => "Черновик",
            "front_name" => "isDraft",
        ],
        "created" => [
            "label" => "Дата добавления",
            "front_name" => "created",
        ],
        "updated" => [
            "label" => "Дата изменения",
            "front_name" => "updated",
        ],
    ];

    public function __construct($attributes = [])
    {
        if (isset($attributes["id"])) {
            parent::__construct($attributes["id"]);
        } else {
            parent::__construct();
        }

        if (isset($attributes)) {
            foreach ($attributes as $key => $value) {
                if (isset(self::ATTR_PARAMS[$key])) {
                    $this->attributes[$key] = $value;
                }
            }
        }
    }
}