<?php


namespace myClasses;


class Registry
{
    private static $instance = null;
    private $values;

    private function __construct()
    {
        $this->getConf();

        return $this;
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    private function getConf()
    {
        $conf_path = __DIR__ . "/../config/main-local.php";
        if (file_exists($conf_path)) {
            $conf = include_once ($conf_path);
            $this->values = $conf;

        } else {
            throw new \Exception("Создайте файл /config/main-local.php");
        }
    }
}