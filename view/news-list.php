<?php
/*
 * Представление списка новостей
 * */
?>
<div class="container b-news">
    <div class="b-news__add-buttons">
        <button type="button" @click="addNews(false)" class="btn btn-success">Добавить пустую</button>
        <button type="button" @click="addNews(true)" class="btn btn-primary">Добавить и редактировать</button>
    </div>
    <div v-for="newsItem in news" class="b-news__item row">
        <div class="row gx-5">
            <div class="col-6 b-news-item__striped">
                <span v-if="newsItem.isDraft">(Черн.)</span>
                {{ newsItem.title }} <span v-if="newsItem.publishedDate">(опубликована {{ newsItem.publishedDate }})</span><br>
                {{ newsItem.descriptionShort }}<br>
                <div v-html="newsItem.descriptionLong" class="b-news__long-text"></div>
                <div v-if="newsItem.image">
                    <img style="max-height: 70px;" :src="'/src/image/' + newsItem.image">
                </div>
            </div>
            <div class="col-2">
                <div class="row gy-2">
                    <button type="button" @click="editNews(newsItem)" class="btn btn-outline-info">Изменить</button>
                    <br>
                    <button type="button" @click="deleteNews(newsItem)" class="btn btn-outline-danger">Удалить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="b-news__add-buttons">
        <button type="button" @click="addNews(false)" class="btn btn-success">Добавить пустую</button>
        <button type="button" @click="addNews(true)" class="btn btn-primary">Добавить и редактировать</button>
    </div>
</div>