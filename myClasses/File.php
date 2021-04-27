<?php


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
    private $max_size_MB = 5;

    public function __construct($file_data)
    {
        $this->data = $file_data;
    }

    public function saveImage($path): bool
    {
        $file_data = $this->data;
        $file_size = strlen(file_get_contents($file_data)) / (1024 * 1024);
        if ($file_size > $this->max_size_MB) {
//            todo: тут нужно откруглить красиво
            throw new \Exception("файл весит {$file_size} Мб, а должен не больше {$this->max_size_MB} Мб", 500);
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