<?php
/*
 * Класс, который инициирует работу с бд: читает настройки и создает PDO
 * */

namespace myClasses;


class Registry
{
    private static $instance = null;
    private $values;
    private $pdo;

    private function __construct()
    {
        try {
            $this->getConf();

            $db_conf = $this->values["db"];
            $this->pdo = new \PDO("{$db_conf["type"]}:host={$db_conf["host"]};dbname={$db_conf["db_name"]}", $db_conf["username"], $db_conf["password"]);
        } catch (ConfException $e) {
            throw new ConfException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("ОШИБКА ПРИ ПОДКЛЮЧЕНИИ К БД. ПРОВЕРЬТЕ НАСТРОЙКИ В main-local.php", 500);
        }


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
            throw new ConfException("Создайте файл /config/main-local.php");
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}