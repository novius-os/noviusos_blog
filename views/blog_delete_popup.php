<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
?>
<div id="<?= $uniqid = uniqid('id_') ?>" class="fieldset standalone">
    <input type="hidden" name="id" value="<?= $blog->id ?>" />
    <p>
        <?= Str::tr(__('You are about to delete the blog post <span style="font-weight: bold;">":blog_title"</span>. Are you sure you want to continue?'), array('blog_title' => $blog->blog_title)) ?>
    </p>
    <p>&nbsp;</p>
    <p>
        <button type="submit" class="primary ui-state-error" data-icon="trash" data-id="confirmation"><?= __('Confirm the deletion') ?></button>
        &nbsp; <?= __('or') ?> &nbsp;
        <a href="#" data-id="cancel"><?= __('Cancel') ?></a>
    </p>
</div>

<script type="text/javascript">
    require(['jquery-nos'], function($nos) {
        $nos(function() {
            var $container     = $nos('#<?= $uniqid ?>').form();
            var $confirmation  = $container.find('button[data-id=confirmation]');

            // Create a form so we can retrieve its data with jQuery.serialize()
            $container.wrapInner('<form></form>');
            $confirmation.click(function(e) {
                e.preventDefault();
                $container.xhr({
                    url : 'admin/noviusos_blog/blog/delete_confirm',
                    method : 'POST',
                    data : $container.find('form').serialize(),
                    success : function(json) {
                        $container.dialog('close');
                        $nos.dispatchEvent('reload.noviusos_blog');
                    }
                });
            });

            $container.find('a[data-id=cancel]').click(function(e) {
                e.preventDefault();
                $container.dialog('close');
            });

        });
    });
</script>