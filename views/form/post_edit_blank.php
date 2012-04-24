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
<div id="<?= $uniqid = uniqid('id_') ?>" class="blank_slate">
<?php if (count($possible) > 0) { ?>
    <p><?= strtr(__('This post has not been added in {lang} yet.'), array(
        '{lang}' => Arr::get(Config::get('locales'), $lang, $lang),
    )) ?></p>
    <p>&nbsp;</p>

    <p><?= __('To add this version, you have two options: ') ?></p>
    <p>&nbsp;</p>
<?php } else { ?>
    <p><?= __('There isn\'t any version of this post yet.') ?></p>
<?php } ?>
    <ul style="margin-left:1em;">
        <li>
            <span class="ui-icon ui-icon-bullet" style="display:inline-block;"></span>
            <form action="admin/noviusos_blog/form/edit" style="display:inline-block;">
                <?= Form::hidden('new_lang', 1) ?>
                <?= Form::hidden('lang',      $lang) ?>
                <?= Form::hidden('common_id', $common_id) ?>
                <?= count($possible) > 0 ? __('Start from scratch ') : strtr(__('Start in {lang}'), array('{lang}' => Arr::get(Config::get('locales'), $lang, $lang))) ?>
                <button type="submit" class="primary" data-icon="plus"><?= __('Add') ?></button>
            </form>
        </li>
<?php if (count($possible) > 0) { ?>
        <li>
            <span class="ui-icon ui-icon-bullet" style="display:inline-block;"></span>
            <form action="admin/noviusos_blog/form/edit" style="display:inline-block;">
                <?= Form::hidden('new_lang', 1) ?>
                <?= Form::hidden('lang',      $lang) ?>
                <?= Form::hidden('common_id', $common_id) ?>
                <?php
                if (count($possible) == 1) {
                    echo Form::hidden('create_from_id', key($possible));
                    $selected_lang = current($possible);
                } else {
                    $selected_lang = Form::select('create_from_id', null, $possible);
                }

                echo strtr(__('Start with the content from the {lang} version'), array(
                    '{lang}' => $selected_lang,
                ));
                ?>
                <button type="submit" class="primary" data-icon="plus"><?= __('Add') ?></button>
            </form>
        </li>
<?php } ?>
    </ul>
</div>

<script type="text/javascript">
    require(['jquery-nos'], function ($nos) {
        $nos(function () {
            var $container = $nos('#<?= $uniqid ?>').form(),
	            $form = $container.find('form')
		            .submit(function(e) {
		                e.preventDefault();
		                $container.load($form.get(0).action, $form.serialize(), function() {
		                    $container.removeClass('blank_slate');
		                    //var $wijtabs = $container.closest(':wijmo-wijtabs');
		                    $container.closest('.ui-tabs-panel').trigger('blank_slate');
		                })
		            });
        });
    });
</script>