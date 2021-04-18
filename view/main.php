<html>
<head>
</head>
<body>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
<div id="app">
    <ul>
        <li v-for="cur_news in news">
            {{ cur_news.title }} {{ cur_news.age }}
            <button @click="editNews(cur_news)">Изменить!</button>
        </li>
    </ul>
    <button @click="addNews">
        Добавить
    </button>
    <dialog ref="modal" close>
        <div v-if="news_to_edit !== null">
            <input type="text" v-model="news_to_edit.title">
            <input type="number" v-model="news_to_edit.age">
            <button @click="saveModal(news_to_edit)">Сохранить и закрыть</button>
            <button @click="closeModal">Закрыть</button>
        </div>

    </dialog>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script>
    var sort_id = 1;
    var new_id = -1;

    const app = new Vue({
        el: '#app',
        data: {
            news: null,
            news_to_edit: null,
        },
        created () {
            fetch('/test')
            .then(response => response.json())
            .then(json => {
                this.news = json.news;
                this.news.forEach(obj => obj.sort_id = sort_id++);
            });
        },
        methods: {
            addNews: function () {
                this.news_to_edit = {
                    title: 'Новая новость',
                    sort_id: sort_id++,
                    new_id: new_id--
                };
                var modal = this.$refs['modal'];
                modal.showModal();
            },
            editNews: function (e) {
                this.news_to_edit = Object.assign({}, e);
                var modal = this.$refs['modal'];
                modal.showModal();
            },
            saveModal: function (e) {
                this.news = this.news.filter(obj => obj.id !== e.id);
                this.news.push(e);
                this.news.sort((a, b) => {
                   return a.sort_id - b.sort_id;
                });
                var modal = this.$refs['modal'];
                modal.close();
            },
            closeModal: function () {
                var modal = this.$refs['modal'];
                modal.close();
            }
        }
    });
</script>
</body>
</html>