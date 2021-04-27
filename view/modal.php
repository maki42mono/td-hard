<?php
/*
 * Представление окна для редактирование одной новости
 * */
?>
<dialog ref="modal" class="b-modal" close>
    <div v-if="newsItemEditable !== null">
<!--        todo: тут ограничения тоже с сервера получать нужно -->
        <div class="b-modal__row">
            <div class="b-modal__item">
                <label for="title" class="b-modal__label">Заголовок:</label>
                <input type="text" id="title" v-model="newsItemEditable.title" maxlength="50" autofocus>
            </div>
            <div class="b-modal__item">
                <label for="published-date" class="b-modal__label">Дата публикации:</label>
                <input type="date" id="published-date" v-model="newsItemEditable.publishedDate">
            </div>
            <div class="b-modal__item">
                <button type="button" @click="closeModal" class="btn btn-outline-dark close b-modal__close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="b-modal__row">
            <div class="b-modal__item">
                <label for="description-short" class="b-modal__label">Краткое описание:</label>
                <input type="text" id="description-short" v-model="newsItemEditable.descriptionShort" maxlength="200">
            </div>
            <div class="b-modal__item">
                <label for="is_draft" class="b-modal__label">Черновик</label>
                <input type="checkbox" id="is_draft" v-model="newsItemEditable.isDraft">
            </div>
            <div class="b-modal__item">
                <button class="btn btn-success" @click="saveModal(newsItemEditable)">Сохранить и закрыть</button>
            </div>
        </div>
        <div class="row b-modal__row">
            <div class="col-7">
                <label for="description-long" class="b-modal__label">Подробное описание:</label><br>
                <textarea id="description-long" v-model="newsItemEditable.descriptionLong" rows="12" cols="50"></textarea>
            </div>
            <div class="col-3">
                <div v-if="newsItemEditable.image || hasLoadedImage">
                    <img style="max-height: 70px;"
                         :src="(hasLoadedImage ? '' : '/src/image/') + newsItemEditable.image">
                </div>
                <input type="file" id="file" class="btn btn-outline-success b-modal__file" ref="modalFile" @change="uploadFile(newsItemEditable)">
            </div>
        </div>


    </div>

</dialog>