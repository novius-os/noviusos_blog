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
<input type="hidden" name="id" value="<?= $blog->id ?>" />
<p>
    <?= Str::tr(__('You are about to delete the blog post <span style="font-weight: bold;">":blog_title"</span>. Are you sure you want to continue?'), array('blog_title' => $blog->blog_title)) ?>
</p>