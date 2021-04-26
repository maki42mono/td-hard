<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>

<style>
    .b-paginator__li > a {
        /*display: block;*/
        padding: 10px 20px;
        text-decoration: none;
        color: black;
    }

    li.b-paginator__li {
        padding-left: 0;
        padding-right: 0;
    }

    .b-paginator__li--active {
        background-color: gold;
    }

    .b-news__item {
        padding: 10px 0;
    }

    .b-news > .b-news__item:nth-child(odd) .b-news-item__striped {
        background: #f5f5f5;
    }
</style>
<div class="container-md">
    <h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
    <div id="app">
        <?php
        include ("paginator.php");
        include ("news-list.php");
        include ("paginator.php");
        include ("modal.php");
        ?>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://unpkg.com/vuejs-paginate@latest"></script>
<script src="/src/js/main.js?<?= time() ?>"></script>
<script>

</script>
</body>
</html>