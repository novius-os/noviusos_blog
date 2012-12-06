<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$base = \Config::load('noviusos_blognews::common/post', true);

$base['actions'] = array(
    'Nos\BlogNews\Blog\Model_Post.add' => array(
        'label' => __('Add a post'),
    ),
    'Nos\BlogNews\Blog\Model_Post.edit' => array(
        'label' => __('Edit this post'),
    ),
    'Nos\BlogNews\Blog\Model_Post.delete' => array(
        'label' => __('Delete this post'),
    ),
);

return $base;