{extends file="layout.tpl"}

{block name="content"}

    <h1>Список всех блогов категории - {$category.name}</h1>

    <div>
        <p style="margin-bottom: 0">Сортировать по:</p>
        <a href="/?page=category&id={$category.id}&sort=date">дате</a> |
        <a href="/?page=category&id={$category.id}&sort=views">просмотрам</a>
    </div>

    <ul>
        {foreach from=$articles item=article}
            <li>
                <a href="/?page=article&id={$article.id}">
                    {$article.title}
                </a>
                <small>
                    Кол-во просмотров: {$article.views}
                </small>
            </li>
        {/foreach}
    </ul>

{/block}
