<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
<style>
    .b-paginator__li > a {
        display: block;
    }

    .b-paginator__li--active {
        background-color: gold;
    }
</style>
<div id="app">
    <?php
    include ("paginator.php");
    include ("news-list.php");
    include ("paginator.php");
    include ("modal.php");
    ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://unpkg.com/vuejs-paginate@latest"></script>
<script src="/src/js/main.js?<?= time() ?>"></script>
<script>

</script>
</body>
</html>