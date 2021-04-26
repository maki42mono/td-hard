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