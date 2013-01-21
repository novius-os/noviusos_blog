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
$base['i18n'] = array(
    // Crud
    'notification item added' => __('All right, your new post has been added.'),
    'notification item deleted' => __('The post has been deleted.'),

    // General errors
    'notification item does not exist anymore' => __('This post doesn’t exist any more. It has been deleted.'),
    'notification item not found' => __('We cannot find this post.'),

    // Blank slate
    'translate error parent not available in context' => __('We’re afraid this post cannot be added to {{context}} because its <a>parent</a> is not available in this context yet.'),
    'translate error parent not available in language' => __('We’re afraid this post cannot be translated into {{language}} because its <a>parent</a> is not available in this language yet.'),

    // Deletion popup
    'deleting item title' => __('Deleting the post ‘{{title}}’'),
    'deleting confirmation' => __('Last chance, there’s no undo. Do you really want to delete this post?'),

    # Delete action's labels
    'deleting button 1 item' => __('Yes, delete this post'),

    '1 item' => __('1 post'),
    'N items' => __('{{count}} posts'),

    # Keep only if the model has the behaviour Contextable
    'deleting with N contexts' => __('This post exists in <strong>{{context_count}} contexts</strong>.'),
    'deleting with N languages' => __('This post exists in <strong>{{language_count}} languages</strong>.'),

    'deleting following contexts' => __('Delete this post in the following contexts:'),
    'deleting following languages' => __('Delete this post in the following languages:'),
);

return $base;