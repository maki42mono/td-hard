<div class="container b-news">
    <div v-for="newsItem in news" class="b-news__item row">
        <div class="row gx-5">
            <div class="col-6 b-news-item__striped">
                <span v-if="newsItem.isDraft">(Черн.)</span>
                {{ newsItem.title }} (опубликована {{ newsItem.publishedDate }})<br>
                {{ newsItem.descriptionShort }}
            </div>
            <div class="col-2">
                <div class="row gy-2">
                    <button type="button" @click="editNews(newsItem)" class="btn btn-outline-primary">Изменить</button>
                    <br>
                    <button type="button" @click="deleteNews(newsItem)" class="btn btn-outline-danger">Удалить</button>
                </div>
            </div>
        </div>
        <div class="row">
            {{ newsItem.descriptionLong }}
        </div>
        <div class="row">
            <div v-if="newsItem.image">
                <img style="max-height: 70px;" :src="'/src/image/' + newsItem.image">
            </div>
        </div>
    </div>
</div>
<button @click="addNews(true)">
    Добавить и редактировать
</button>
<button @click="addNews(false)">
    Добавить пустую
</button>