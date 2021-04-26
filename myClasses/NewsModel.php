<?php


namespace myClasses;


class NewsModel extends DomainObject
{
//    todo: вынести в функцию и в низ класса
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

    public function __construct(array $attributes = [], bool $from_front = false)
    {
        if (isset($attributes["id"])) {
            parent::__construct($attributes["id"]);
        } else {
            parent::__construct();
        }

        if (isset($attributes)) {
            foreach ($attributes as $key => $value) {
                $my_key = $key;
//                Если данные пришли с фронта — меняем соответствующие поля с фронта на БД
                if ($from_front) {
                    $my_key = array_search($my_key, array_column(self::ATTR_PARAMS, 'front_name'));
                    $my_key = array_keys(self::ATTR_PARAMS)[$my_key];
                }
                if (isset(self::ATTR_PARAMS[$my_key])) {
                    $this->attributes[$my_key] = $value;
                }
            }
        }
    }

//    todo: вынести в домейн обджект, а тут добавить класс таргет!
//      todo: и добавить проверки перед сохранением!
//    public static function findAll()
//    {
//        $news_mapper = new NewsMapper();
//        $all_news = $news_mapper->findAll();
//
//        return $all_news;
//    }

    public static function findAll(): array
    {
        $mapper = self::targetMapper();
        return parent::findAllByMapper($mapper);
    }

//    public function save()
//    {
//        $news_mapper = new NewsMapper();
//        $news_mapper->update($this);
//    }

    protected static function targetMapper(): Mapper
    {
        return new NewsMapper();
    }

    public static function getTotalCount(): int
    {
        $mapper = self::targetMapper();
        return parent::getTotalCountByMapper($mapper);
    }
}