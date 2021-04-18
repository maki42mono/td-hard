<?php


namespace myClasses;


class MyController
{
    private const VIEW_PATH = __DIR__ . "/../view";

    public static function run()
    {


        if (isset($_REQUEST["r"])) {
            $req = $_REQUEST["r"];
            self::AJAXHandler($req);
        }

        self::runMyView("main");
    }

    private static function AJAXHandler($req)
    {
        if ($req == "test") {
            $test_arr = [
                "products" =>
                    [
                        [
                            "title" => "Maks",
                            "age" => 27,
                        ],
                        [
                            "title" => "Nastya",
                            "age" => 28,
                        ]
                    ]
            ];

            echo json_encode($test_arr);
        }
        exit;
    }

    private static function runMyView($view_name)
    {
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