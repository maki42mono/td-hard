<html>
<head>
</head>
<body>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
<div id="app">
    <ul>
        <li v-for="test in products">
            {{ test.title }}
        </li>
    </ul>
    <button @click="products.push({title: 'Новая новость'})">
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
        }
    })
</script>
</body>
</html>