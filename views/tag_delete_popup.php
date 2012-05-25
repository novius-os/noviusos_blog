<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
$nb = count($tag->blogs);
?>
<div id="<?= $uniqid = uniqid('id_') ?>" class="fieldset standalone">
    <input type="hidden" name="id" value="<?= $tag->id ?>" />
    <p>
        <?= Str::tr(__('You are about to delete the tag <span style="font-weight: bold;">":title"</span>. Are you sure you want to continue ?'), array('title' => $tag->tag_label)) ?>
    </p>
    <p>&nbsp;</p>
    <p>
        <?= Str::tr(_('At this moment, <span style="font-weight: bold;">:number</span> blog post(s) are using this tag.'), array('number' => $nb)) ?>
    </p>
    <p>&nbsp;</p>
    <p>
        <?= _('To confirm the deletion, you need to enter this number in the field below:') ?>
    </p>
    <p>
        <?= Str::tr(_('Yes, I want to delete the tag and thus remove it on :input blog post(s).'), array('input' => '<input data-id="verification1" data-verification="'.$nb.'" size="'.(mb_strlen($nb) + 1).'" />')) ?>
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
            var $verification1 = $container.find('input[data-id=verification1]');

            // Create a form so we can retrieve its data with jQuery.serialize()
            $container.wrapInner('<form></form>');
            $confirmation.click(function(e) {
                e.preventDefault();
                if ($verification1.length && $verification1.val() != $verification1.data('verification')) {
                    $nos.notify(<?= \Format::forge()->to_json(__('Wrong confirmation')); ?>, 'error');
                    return;
                }

                $container.xhr({
                    url : 'admin/noviusos_blog/tag/delete_confirm',
                    method : 'POST',
                    data : $container.find('form').serialize(),
                    success : function(json) {
                        $container.dialog('close');
                        $nos.dispatchEvent('reload.noviusos_blog_tags');
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