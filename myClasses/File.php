<?php


namespace myClasses;


class File
{
    private $data;
    private $name;

    public function __construct($file_data)
    {
        $this->data = $file_data;
    }

    public function saveImage($path): bool
    {
        $file_data = $this->data;
        $extension = explode('/', mime_content_type($file_data))[1];
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