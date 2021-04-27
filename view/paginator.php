<?php
/*
 * Представление 1-й строчки пагинатора, используется в приложении 2 раза
 * */
?>
<!--    todo: по 20 страниц? Или по 20 эементов на странице? -->
<paginate
    v-model="activePage"
    :page-count="pagesCount"
    :page-range="3"
    :click-handler="clickCallback"
    :prev-text="'<<<'"
    :next-text="'>>>'"
    :active-class="'b-paginator__li--active'"
    :page-class="'list-group-item btn btn-outline-info b-paginator__li'"
    :prev-class="'list-group-item btn btn-outline-info b-paginator__li'"
    :next-class="'list-group-item btn btn-outline-info b-paginator__li'"
    :container-class="'list-group list-group-horizontal'">
  </span>
</paginate>