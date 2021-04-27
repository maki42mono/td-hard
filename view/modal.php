<?php
/*
 * Представление окна для редактирование одной новости
 * */
?>
<dialog ref="modal" close>
    <div v-if="newsItemEditable !== null">
<!--        todo: тут ограничения тоже с сервера получать нужно -->
        <input type="text" v-model="newsItemEditable.title" maxlength="50">
        <input type="date" v-model="newsItemEditable.publishedDate">
        <input type="text" v-model="newsItemEditable.descriptionShort" maxlength="200">
        <input type="checkbox" id="is_draft" v-model="newsItemEditable.isDraft">
        <label for="is_draft">Черновик</label>
        <button @click="saveModal(newsItemEditable)">Сохранить и закрыть</button>
        <button @click="closeModal">Закрыть</button><br>
        <textarea v-model="newsItemEditable.descriptionLong" maxlength="500"></textarea>
        <div v-if="newsItemEditable.image || hasLoadedImage">
            <img style="max-height: 70px;"
                 :src="(hasLoadedImage ? '' : '/src/image/') + newsItemEditable.image">
        </div>
        <input type="file" id="file" ref="modalFile" @change="uploadFile(newsItemEditable)">
    </div>

</dialog>