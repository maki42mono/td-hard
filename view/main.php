<html>
<head>
</head>
<body>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
<div id="app">
    <ul>
        <li v-for="newsItem in news">
            <span v-if="newsItem.isDraft">(Ч)</span>
            {{ newsItem.title }} {{ newsItem.publishedDate }} {{ newsItem.descriptionShort }} <br>
            {{ newsItem.descriptionLong }}
            <button @click="editNews(newsItem)">Изменить!</button><br>
            <img style="max-height: 70px;" :src="'/src/images/' + newsItem.image">
            <br><br>
        </li>
    </ul>
    <button @click="addNews">
        Добавить
    </button>
    <dialog ref="modal" close>
        <div v-if="newsItemEditable !== null">
            <input type="text" v-model="newsItemEditable.title">
            <input type="date" v-model="newsItemEditable.publishedDate">
            <input type="text" v-model="newsItemEditable.descriptionShort">
            <input type="checkbox" id="is_draft" v-model="newsItemEditable.isDraft">
            <label for="is_draft">Черновик</label>
            <button @click="saveModal(newsItemEditable)">Сохранить и закрыть</button>
            <button @click="closeModal">Закрыть</button><br>
            <textarea>{{ newsItemEditable.descriptionLong }}</textarea>
            <img style="max-height: 70px;"
                 :src="(hasLoadedImage ? '' : '/src/images/') + newsItemEditable.image">
            <input type="file" id="file" ref="modalFile" @change="uploadFile(newsItemEditable)">
        </div>

    </dialog>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script>
    var sortId = 1;
    var newId = -1;

    const app = new Vue({
        el: '#app',
        data: {
            news: null,
            newsItemEditable: null,
            hasLoadedImage: false
        },
        created () {
            fetch('/getData')
            .then(response => response.json())
            .then(json => {
                this.news = json.news;
                this.news.forEach(obj => obj.sortId = sortId++);
            });
        },
        methods: {
            addNews: function () {
                this.newsItemEditable = {
                    title: 'Новая новость',
                    sortId: sortId++,
                    newId: newId--
                };
                var modal = this.$refs['modal'];
                modal.showModal();
            },
            editNews: function (e) {
                this.newsItemEditable = Object.assign({}, e);
                var modal = this.$refs['modal'];
                modal.showModal();
            },
            async saveModal(e) {
                var that = this;
                this.news = this.news.filter(obj => obj.id !== e.id);
                this.news.push(e);
                this.news.sort((a, b) => {
                   return a.sortId - b.sortId;
                });

                // Simple POST request with a JSON body using fetch
                const requestOptions = {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(that.newsItemEditable)
                };
                console.log(requestOptions);
                const response = await fetch("/sendData", requestOptions);
                const data = await response.json();
                console.log(data);


            },
            closeModal: function () {
                var modal = this.$refs['modal'];
                this.hasLoadedImage = false;
                modal.close();
            },
            uploadFile: function () {
                var file = this.$refs['modalFile'].files;
                var reader = new FileReader();
                reader.readAsDataURL(file[0]);
                var that = this;
                reader.onload = function () {
                    that.hasLoadedImage = true;
                    that.newsItemEditable.image = reader.result;
                };
            }
        }
    });
</script>
</body>
</html>