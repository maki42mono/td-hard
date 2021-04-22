<?php


namespace myClasses;


class MyController
{
    private const VIEW_PATH = __DIR__ . "/../view";
    private const IMAGE_PATH = __DIR__ . "/../src/image";

    public static function run()
    {
        Registry::instance();

        if (isset($_REQUEST["r"])) {
            $req = $_REQUEST["r"];
           self::AJAXHandler($req);
        }

       self::runMyView("main");
    }

    private static function AJAXHandler($req)
    {
        $action = "action{$req}";
        $rself = new \ReflectionClass(self::class);
        if ($rself->hasMethod($action)) {
           self::$action();
        }

        exit;
    }

    private static function actionSaveData() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data)) {

            //todo: вынести отдельно
            $file_data = $data["image"];
            $extension = explode('/', mime_content_type($file_data))[1];
            $file_name = time() . "." . $extension;
            $location = self::IMAGE_PATH . "/{$file_name}";
            file_put_contents($location, file_get_contents($file_data));
            $data["image"] = $file_name;

            $news_model = new NewsModel($data, true);
            $news_model->save();
        }


    }

    private static function actionGetData() {

        $all_news = NewsModel::findAll();

        $all_news_arr = [];
        foreach ($all_news as $news) {
            $news_arr = $news->attributes;
            $curr_news = [];
            foreach ($news_arr as $key => $value) {
                $curr_news[NewsModel::ATTR_PARAMS[$key]["front_name"]] = $value;
            }
            $all_news_arr[] = $curr_news;
        }

        echo json_encode(["news" => $all_news_arr]);
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