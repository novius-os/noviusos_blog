<li class="comment" id="comment<?= $comment->comm_id ?>">
    <div class="comment_infos">
        <span class="comment_author"><a href="mailto:<?= $comment->comm_email ?>" class="mailto">Commentaire par <?= $comment->comm_author ?></a></span>
        <span class="comment_date"><?= $comment->comm_created_at ?></span>
        <br class="clearfloat">
    </div>
    <div class="comment_content">
        <?= Str::textToHtml($comment->comm_content) ?>
    </div>
</li>