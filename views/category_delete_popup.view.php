<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
$nb = count($category->blogs);
?>
<input type="hidden" name="id" value="<?= $category->id ?>" />
<p>
    <?= Str::tr(__('You are about to delete the category <span style="font-weight: bold;">":title"</span>. Are you sure you want to continue ?'), array('title' => $category->blgc_title)) ?>
</p>
<p>
    <?= Str::tr(_('At this moment, <span style="font-weight: bold;">:number</span> blog post(s) are using this category.'), array('number' => $nb)) ?>
</p>
<p>
    <?= _('To confirm the deletion, you need to enter this number in the field below:') ?>
</p>
<p>
    <?= Str::tr(_('Yes, I want to delete the category and thus remove it on :input blog post(s).'), array('input' => '<input class="verification" data-verification="'.$nb.'" size="'.(mb_strlen($nb) + 1).'" />')) ?>
</p>
