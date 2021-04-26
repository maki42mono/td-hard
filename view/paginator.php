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