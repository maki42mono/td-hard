<?php
// получаем все классы. Один класс — одно задание
$my_load = function ($classname) {
    $path = __DIR__ . DIRECTORY_SEPARATOR;

    if (file_exists($path)) {
        require_once($path);
    }
};


\spl_autoload_register($my_load);

\myClasses\MyController::run();

?>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков</h1>