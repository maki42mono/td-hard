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
            <div v-if="newsItem.image">
                <img style="max-height: 70px;" :src="'/src/image/' + newsItem.image">
            </div>
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
            <textarea v-model="newsItemEditable.descriptionLong"></textarea>
            <div v-if="newsItemEditable.image || hasLoadedImage">
            <img style="max-height: 70px;"
                 :src="(hasLoadedImage ? '' : '/src/image/') + newsItemEditable.image">
            </div>
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
            //todo: получать с бекенда
            newsOnPage: 4,
            pagesCount: 1,
            activePage: 1,
            isNewItem: false,
        },
        async created () {
            const data = await this.getNews();
            // сортируем новости, чтобы при добавлении новых оставлять текущий порадок без запросов к бд


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
                this.pagesCount = Math.ceil(this.allNewsCount / this.newsOnPage);
                if (this.pagesCount == 0) {
                    this.pagesCount = 1;
                }
            },
            addNews: function (addAndEdit = false) {
                this.newsItemEditable = {
                    title: 'Новая новость',
                    isDraft: true,
                    sortId: sortId++,
                };
                this.isNewItem = true;
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
                if (response.status != 200) {
                    return false;
                }
                if (this.news.length == 1) {
                    this.activePage--;
                }
                await this.getNews();

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
                if (response.status != 200) {
                    return false
                }

                var savedNews = await response.json();
                if (! this.isNewItem) {
                    this.addItemToNewsCollection(savedNews);
                } else if (this.activePage < this.pagesCount) {
                    this.activePage = this.pagesCount;
                    await this.getNews();
                    this.isNewItem = false;
                    return true;
                } else if (this.activePage == this.pagesCount) {
                    if (this.news.length < this.newsOnPage) {
                        this.addItemToNewsCollection(savedNews);
                    } else {
                        this.pagesCount++;
                        this.allNewsCount = 1;
                        this.activePage = this.pagesCount;
                        this.news = [savedNews];
                    }
                }

                this.isNewItem = false;
                return true;
            },
            addItemToNewsCollection: function (newsItem) {
                this.news = this.news.filter(obj => obj.id != newsItem.id);
                newsItem.sortId = this.newsItemEditable.sortId;
                this.newsItemEditable.image = newsItem.image;
                this.news.push(newsItem);
                this.news.sort((a, b) => {
                    return a.sortId - b.sortId;
                });
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
                this.activePage = pageNum;
                this.getNews();
            },
        }
    });
</script>
</body>
</html>