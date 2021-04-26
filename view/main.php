<html>
<head>
</head>
<body>
<h1>Максим Пух, тестовое задание для бекенд(фуллстек)-разработчиков.</h1>
<style>
    .b-paginator > ul.hr {
        margin: 0; /* Обнуляем значение отступов */
        padding: 4px; /* Значение полей */
    }

    .b-paginator > li {
        display: inline; /* Отображать как строчный элемент */
        margin-right: 5px; /* Отступ слева */
        border: 1px solid #000; /* Рамка вокруг текста */
        padding: 3px; /* Поля вокруг текста */
    }

    .b-paginator__li--active {
        background-color: gold;
    }
</style>
<div id="app">
<!--    todo: по 20 страниц? Или по 20 эементов на странице? -->
    <paginate
            v-model="activePage"
            :page-count="pagesCount"
            :page-range="3"
            :click-handler="clickCallback"
            :prev-text="'<<<'"
            :next-text="'>>>'"
            :active-class="'b-paginator__li--active'"
            :container-class="'b-paginator'">
    </paginate>
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
    <paginate
            v-model="activePage"
            :page-count="pagesCount"
            :page-range="3"
            :click-handler="clickCallback"
            :prev-text="'<<<'"
            :next-text="'>>>'"
            :active-class="'b-paginator__li--active'"
            :container-class="'b-paginator'">
    </paginate>
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
<script src="https://unpkg.com/vuejs-paginate@latest"></script>
<script>
    var sortId = 1;

    Vue.component('paginate', VuejsPaginate);

    const app = new Vue({
        el: '#app',
        data: {
            news: null,
            newsItemEditable: null,
            hasLoadedImage: false,
            uploadedImage: null,
            allNewsCount: null,
            newsOnPage: 2,
            pagesCount: 0,
            activePage: 1,
        },
        async created () {
            const data = await this.getNews();

            // сортируем новости, чтобы при добавлении новых оставлять текущий порадок без запросов к бд

            this.pagesCount = Math.ceil(this.allNewsCount / this.newsOnPage);
        },
        methods: {
            async getNews() {
                const requestOptions = {
                    method: "POST",
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    body: JSON.stringify({page: this.activePage - 1})
                };
                const response = await fetch("/getData", requestOptions);

                if (response.status != 200) {
                    return false;
                }

                var data = await response.json();

                data.news.forEach(e => {
                    e.sortId = sortId++;
                });
                this.news = data.news;
                this.allNewsCount = data.allNewsCount;
            },
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
            },
            clickCallback: function (pageNum) {
                // console.log(pageNum)
                this.activePage = pageNum;
                this.getNews();
            },
        }
    });
</script>
</body>
</html>