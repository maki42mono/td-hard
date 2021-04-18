<html>
<head>
</head>
<body>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
<div id="app">
    <ul>
        <li v-for="product in products">
            {{ product.title }}
            <button @click="editNews(product)">Изменить!</button>
        </li>
    </ul>
    <button @click="addNews">
        Добавить
    </button>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script>
    const app = new Vue({
        el: '#app',
        data: {
            products: []
        },
        created () {
            fetch('/test')
            .then(response => response.json())
            .then(json => {
                this.products = json.products
            })
        },
        methods: {
            addNews: function (e) {
                this.products.push({title: 'Новая новость'});
            },
            editNews: function (e) {
                console.log(e.title);
                console.log(e.age);
                // alert(this)
            }
        }
    });
</script>
</body>
</html>