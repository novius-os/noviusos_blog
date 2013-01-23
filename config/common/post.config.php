<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

\Nos\I18n::current_dictionary('noviusos_blog::common');

$base = \Config::load('noviusos_blognews::common/post', true);

$base['actions']['list']['add'] = array(
    'label' => __('Add a post'),
);
$base['i18n'] = array(
    // Crud
    'notification item added' => __('All right, your new post has been added.'),
    'notification item deleted' => __('The post has been deleted.'),

    // General errors
    'notification item does not exist anymore' => __('This post doesn’t exist any more. It has been deleted.'),
    'notification item not found' => __('We cannot find this post.'),

    // Deletion popup
    'deleting item title' => __('Deleting the post ‘{{title}}’'),

    # Delete action's labels
    'deleting button 1 item' => __('Yes, delete this post'),
    'deleting button N items' => __('Yes, delete these {{count}} posts'),

    '1 item' => __('1 post'),
    'N items' => __('{{count}} posts'),

    # Keep only if the model has the behaviour Contextable
    'deleting with N contexts' => __('This post exists in <strong>{{context_count}} contexts</strong>.'),
    'deleting with N languages' => __('This post exists in <strong>{{language_count}} languages</strong>.'),
);

return $base;