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
        $post_data = json_decode(file_get_contents('php://input'), true);

        if (isset($post_data)) {
            $news_data = $post_data["newsData"];
            if($post_data["hasNewImage"]) {
                $file = new File($news_data["image"]);
                $file->saveImage(self::IMAGE_PATH);
                $news_data["image"] = $file->getFileName();
            }

            $news_model = new NewsModel($news_data, true);

            if ($news_model->save()) {
                $news_model->attributes["id"] = $news_model->getId();
                $news_to_front = [];
                foreach ($news_model->attributes as $key => $value) {
                    $news_to_front[NewsModel::ATTR_PARAMS[$key]["front_name"]] = $value;
                }

                echo json_encode($news_to_front);
            }
        }
    }

    private static function actionDeleteData() {
        $post_data = json_decode(file_get_contents('php://input'), true);
        $news_data = $post_data["newsData"];
        $news_model = new NewsModel($news_data, true);

        if ($news_model->delete()) {
            echo json_encode(["msg" => "OK!"]);
        }
    }

    private static function actionGetData() {

        $all_news = NewsModel::findAll();

        $all_news_arr = [];
        foreach ($all_news as $news) {
            $news_arr = $news->attributes;
            $curr_news = [];
//            todo: вынести
            foreach ($news_arr as $key => $value) {
                if ($key == "flag_draft") {
                    $value = (bool)$value;
                }
                $curr_news[NewsModel::ATTR_PARAMS[$key]["front_name"]] = $value;
            }
            $all_news_arr[] = $curr_news;
        }

        echo json_encode([
            "news" => $all_news_arr,
            "allNewsCount" => NewsModel::getTotalCount(),
        ]);
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