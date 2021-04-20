<?php


namespace myClasses;


class MyController
{
    private const VIEW_PATH = __DIR__ . "/../view";
    private const IMAGE_PATH = __DIR__ . "/../src/image";

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
        if ($req == "getData") {
            $test_arr = [
                "news" =>
                    [
                        [
                            "id" => 1,
                            "title" => "Maks",
                            "descriptionShort" => "aaa",
                            "descriptionLong" => "aaaAAAaaa",
                            "publishedDate" => "2020-10-08",
                            "isDraft" => false,
                            "image" => "banana.jpg",
                        ],
                        [
                            "id" => 2,
                            "title" => "Nastya",
                            "descriptionShort" => "bbb",
                            "descriptionLong" => "bbbBBBbb",
                            "publishedDate" => "2019-03-18",
                            "isDraft" => true,
                            "image" => "apple.jpg",
                        ]
                    ]
            ];

            echo json_encode($test_arr);
        } else if ($req == "sendData") {
            $data = json_decode(file_get_contents('php://input'), true);


            $file_data = $data["image"];
            $extension = explode('/', mime_content_type($file_data))[1];
            $location = self::IMAGE_PATH . "/" . time() . ".{$extension}";
            file_put_contents($location, file_get_contents($file_data));
            echo json_encode([$data]);
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