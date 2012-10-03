<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

/*
$config = array(
    'query' => array(
        'model' => '\Nos\BlogNews\Blog\Model_Post',
        'order_by' => array('post_created_at' => 'DESC'),
        'limit' => 20,
    ),
    'search_text' => 'post_title',
    'views' => array(
        'default' => array(
            'name' => __('Default view'),
            'json' => array('static/apps/noviusos_blog/js/admin/blog.js', 'static/apps/noviusos_blognews/js/admin/blognews.js'),
        ),
    ),
);
$appdesk = array(
    'tab' => array(
        'label' => __('Blog'),
    ),
);
*/

$base = \Config::load('noviusos_blognews::controller/admin/appdesk', true);
return $base;
