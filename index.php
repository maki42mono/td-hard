<?php
// получаем все классы. Один класс — одно задание
$my_load = function ($classname) {
    $path = __DIR__ . DIRECTORY_SEPARATOR . "$classname.php";

    if (file_exists($path)) {
        require_once($path);
    }
};


\spl_autoload_register($my_load);

\myClasses\MyController::run();