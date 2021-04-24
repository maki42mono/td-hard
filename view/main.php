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
            <button @click="deleteNews(newsItem)">Удалить…</button><br>
            <img style="max-height: 70px;" :src="'/src/image/' + newsItem.image">
            <br><br>
        </li>
    </ul>
    <button @click="addNews(true)">
        Добавить и редактировать
    </button>
    <button @click="addNews(false)">
        Добавить пустую
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
                 :src="(hasLoadedImage ? '' : '/src/image/') + newsItemEditable.image">
            <input type="file" id="file" ref="modalFile" @change="uploadFile(newsItemEditable)">
        </div>

    </dialog>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script>
    var sortId = 1;

    const app = new Vue({
        el: '#app',
        data: {
            news: null,
            newsItemEditable: null,
            hasLoadedImage: false,
            uploadedImage: null,
        },
        async created () {
            const response = await fetch("/getData");
            const data = await response.json();

            // сортируем новости, чтобы при добавлении новых оставлять текущий порадок без запросов к бд
            data.news.forEach(e => {
                e.sortId = sortId++;
            });
            this.news = data.news;
        },
        methods: {
            addNews: function (addAndEdit = false) {
                this.newsItemEditable = {
                    title: 'Новая новость',
                    sortId: sortId++,
                };
                if (addAndEdit) {
                    var modal = this.$refs['modal'];
                    modal.showModal();
                } else {
                    this.saveNewsItem(this.newsItemEditable);
                }
            },
            editNews: function (e) {
                this.newsItemEditable = Object.assign({}, e);
                var modal = this.$refs['modal'];
                modal.showModal();
            },
            async deleteNews(e) {
                const requestOptions = {
                    method: "POST",
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    body: JSON.stringify({newsData: e})
                };
                const response = await fetch("/deleteData", requestOptions);
                if (response.status == 200) {
                    this.news = this.news.filter(obj => obj.id != e.id);
                }
            },
            async saveModal() {
                if (await this.saveNewsItem()) {
                    app.closeModal();
                }
            },
            async saveNewsItem () {
                var that = this;
                const requestOptions = {
                    method: "POST",
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    body: JSON.stringify({newsData: that.newsItemEditable, hasNewImage: this.hasLoadedImage})
                };
                const response = await fetch("/saveData", requestOptions);
                //todo: делать красивее
                if (response.status == 200) {
                    var savedNews = await response.json();
                    this.news = this.news.filter(obj => obj.id != savedNews.id);
                    savedNews.sortId = that.newsItemEditable.sortId;
                    this.newsItemEditable.image = savedNews.image;
                    this.news.push(savedNews);
                    this.news.sort((a, b) => {
                        return a.sortId - b.sortId;
                    });
                }
                return true;
            },
            closeModal: function () {
                var modal = this.$refs['modal'];
                this.hasLoadedImage = false;
                modal.close();
            },
            uploadFile: function () {
                var that = this;
                var file = this.$refs['modalFile'].files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                that.uploadedImage = file;
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