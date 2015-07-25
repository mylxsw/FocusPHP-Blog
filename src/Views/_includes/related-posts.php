<?php if (!empty($relates) && is_array($relates)) : ?>
<section class="am-panel am-panel-default">
    <div class="am-panel-hd">相关文章</div>
    <div class="am-list blog-list">
        <?php foreach ($relates as $ret): ?>
            <li style="display: none"><a href="article/<?=$ret['id']?>.html"><?=$ret['title']?></a></li>
        <?php endforeach;?>
    </div>
</section>
<?php endif;?>

<?php if (!empty($posts) && is_array($posts)) : ?>
    <section class="am-panel am-panel-default">
        <div class="am-panel-hd">文章列表</div>
        <div class="am-list">
            <?php foreach ($posts as $_post): ?>
                <li><a href="article/<?=$_post['id']?>.html"><?=$_post['title']?></a></li>
            <?php endforeach;?>
        </div>
    </section>
<?php endif;?>