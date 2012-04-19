<div class="comment_form">
    <form class="comment_form" name="TheFormComment" id="TheFormComment" method="post" action="<?= Uri::full() ?>#comments">
        <input type="hidden" name="todo" value="add_comment">
        <div class="comment_form_title"><?= __('Leave your comment:') ?></div>
        <table border="0">
            <tbody><tr>
                <td align="right"><label for="comm_author"><?= __('Name:') ?></label></td>
                <td><input type="text" style="width:300px;" maxlength="100" value="" id="comm_author" name="comm_author"></td>
            </tr>
            <tr>
                <td align="right"><label for="comm_email"><?= __('Email (not published):') ?></label></td>
                <td><input type="text" style="width:300px;" maxlength="100" value="" id="comm_email" name="comm_email"></td>
            </tr>
            <tr><td colspan="2"><label for="comm_content"><?= __('Your comment:') ?></label></td></tr>
            <tr><td colspan="2"><textarea style="width:100%;height:200px;" id="comm_content" name="comm_content"></textarea></td></tr>
            </tbody></table>
        <div class="comment_submit"><input type="submit" value="<?= __('Validate') ?>"></div>
    </form>
</div>