<?php
/*
 * Класс, который помогает работать с файлами
 * */


namespace myClasses;


class File
{
    private $data;
    private $name;
    private $allowed_img_formats = [
        "png",
        "jpg",
        "jpeg",
    ];
    public const MAX_SIZE_MB = 5;

    public function __construct($file_data)
    {
        $this->data = $file_data;
    }

    public function saveImage($path): bool
    {
        $file_data = $this->data;
        $file_size = strlen(file_get_contents($file_data)) / (1024 * 1024);
        $max_size_mb = self::MAX_SIZE_MB;
        if ($file_size > $max_size_mb) {
//            todo: тут нужно откруглить красиво
            throw new \Exception("файл весит {$file_size} Мб, а должен не больше {$max_size_mb} Мб", 500);
        }
        $extension = explode('/', mime_content_type($file_data))[1];
        if (! in_array($extension, $this->allowed_img_formats)) {
            throw new \Exception("файл должен быть png, jpg или jpeg", 500);
        }
        $this->name = time() . "." . $extension;
        $location = $path . "/{$this->name}";
        file_put_contents($location, file_get_contents($file_data));

        return true;
    }

    public function getFileName(): string
    {
        return $this->name;
    }
}