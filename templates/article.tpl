{extends file="layout.tpl"}


{block name="content"}
    <article>
        <h1>{$article.title}</h1>

        {if $article.image}
            <img src="/assets/images/{$article.image}" alt="{$article.title}">
        {/if}

        <p>{$article.description}</p>
        <div>
            {$article.content}
        </div>

        <small>
            Кол-во просмотров: {$article.views + 1}
        </small>
    </article>

    {if $similarArticles}
        <section>
            <h3>Похожие блоги</h3>
            <ul>
                {foreach from=$similarArticles item=item}
                    <li>
                        <a href="/?page=article&id={$item.id}">
                            {$item.title}
                        </a>
                    </li>
                {/foreach}
            </ul>
        </section>
    {/if}

{/block}
