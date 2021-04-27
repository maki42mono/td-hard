<?php


namespace myClasses;


class NewsModel extends DomainObject
{
//    todo: вынести в функцию вниз
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
//        пока не выводить. Иначе клиентский код сможет их использовать
        /*"created" => [
            "label" => "Дата добавления",
            "front_name" => "created",
        ],
        "updated" => [
            "label" => "Дата изменения",
            "front_name" => "updated",
        ],*/
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

    public static function findAll(): array
    {
        $mapper = self::targetMapper();
        return parent::findAllByMapper($mapper);
    }

    public static function findInRange(int $rows_count, int $start_from): array
    {
        $mapper = self::targetMapper();
        return parent::findInRangeByMapper($rows_count, $start_from, $mapper);
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

    protected function beforeSave()
    {
        if (! isset($this->attributes["flag_draft"])) {
            $this->attributes["flag_draft"] = 0;
        } else {
            $this->attributes["flag_draft"] = ($this->attributes["flag_draft"]) ? "1" : "0";
        }

        $this->attributes["description_long"] = strip_tags($this->attributes["description_long"], '<a><b><i><strike>');
        if (isset($this->attributes["description_long"]) && mb_strlen($this->attributes["description_long"]) > 500) {
            throw new \Exception("в подробном описании должно быть меньше 500 символов!", 500);
        }

        if (isset($this->attributes["published_date"]) && ! (bool)strtotime($this->attributes["published_date"])) {
//            todo: тут и на клиенте можно проверять, что дата не из будущего
            throw new \Exception("исправьте дату!", 500);
        }

        if (isset($this->attributes["title"]) && mb_strlen($this->attributes["title"]) > 50) {
            throw new \Exception("в заголовке должно быть меньше 50 символов!", 500);
        }

        if (isset($this->attributes["description_short"]) && mb_strlen($this->attributes["description_short"]) > 200) {
            throw new \Exception("в кратком описании должно быть меньше 200 символов!", 500);
        }

        $execute_time = date("Y-m-d H:i:s");
        if ($this->getId()) {
            $this->attributes["updated"] = $execute_time;
        } else {
            $this->attributes["created"] = $execute_time;
        }


    }
}