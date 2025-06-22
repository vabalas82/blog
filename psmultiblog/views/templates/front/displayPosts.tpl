<div class="psmultiblog-home">
    {foreach from=$psmultiblog_posts item=post}
        <h3><a href="{url entity='module' name='psmultiblog' controller='post' rewrite=$post.slug}">{$post.title}</a></h3>
        <p>{truncate strip_tags($post.content) 200 '...'}</p>
    {/foreach}
</div>