<?php


namespace myClasses;


class MyController
{
    private const VIEW_PATH = __DIR__ . "/../view";

    public static function run()
    {
        if (isset($_REQUEST["r"])) {
            $view = $_REQUEST["r"];

            self::runMyView($view);
        }
    }

    private static function runMyView($view_name)
    {
        echo "<h3><a href='/'><<< НАЗАД</a></h3>";

        $path = self::VIEW_PATH . "/{$view_name}.php";
        $path = str_replace("/", DIRECTORY_SEPARATOR, $path);
        if (file_exists($path)) {
            include_once($path);
        } else {
            self::runError();
        }
        exit;
    }

    private static function runError()
    {
        echo "<h2>Такой страницы нет!</h2>";
    }
}