<?php
/*
 * Контейнер приложения: тут подключаются скрипты и стили, а также вызываются вьюшки
 * */
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="/src/css/main.css?2">
</head>
<body>
<div class="container-md">
    <h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
    <div id="app">
        <?php
        include ("paginator.php");
        ?>
        <div class="d-flex justify-content-center">
            <div class="spinner-grow text-success" role="status" v-if="isLoading">
<!--                <span class="sr-only">Loading...</span>-->
            </div>
        </div>
        <?php
        include ("news-list.php");
        include ("paginator.php");
        include ("modal.php");
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<?php
/*
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<?php
 */
?>
<script src="https://unpkg.com/vuejs-paginate@latest"></script>
<script src="/src/js/main.js?3"></script>
</body>
</html>