{extends file="layout.tpl"}

{block name="content"}

    <h1>Abelo</h1>

    {foreach from=$categories item=item}
        <section class="category">
            <div class="category-image">
                <img src="/assets/images/{$item.img}.png" alt="img">
            </div>

            <div class="category-content">
                <h2>{$item.category.name}</h2>
                <p>{$item.category.description}</p>

                <ul>
                    {foreach from=$item.articles item=article}
                        <li>
                            <a href="/?page=article&id={$article.id}">
                                {$article.title}
                            </a>
                        </li>
                    {/foreach}
                </ul>

                <a href="/?page=category&id={$item.category.id}">
                    Все статьи
                </a>
            </div>
        </section>
    {/foreach}

{/block}
