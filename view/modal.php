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