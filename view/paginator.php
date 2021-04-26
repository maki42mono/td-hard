<!--    todo: по 20 страниц? Или по 20 эементов на странице? -->
<paginate
    v-model="activePage"
    :page-count="pagesCount"
    :page-range="3"
    :click-handler="clickCallback"
    :prev-text="'<<<'"
    :next-text="'>>>'"
    :active-class="'b-paginator__li--active'"
    :page-class="'list-group-item btn btn-outline-secondary b-paginator__li'"
    :prev-class="'list-group-item btn btn-outline-secondary'"
    :next-class="'list-group-item btn btn-outline-secondary'"
    :container-class="'list-group list-group-horizontal'">
</paginate>