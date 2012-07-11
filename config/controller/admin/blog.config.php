<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'base_url'  => 'admin/noviusos_blog/blog',
    'item_text' => __('post'),
    'tabInfos' => array(
        'label' => function($blog) {
            return $blog->is_new() ? __('Add a post') : $blog->blog_title;
        },
        'iconUrl' => 'static/apps/noviusos_blog/img/16/blog.png',
    ),
    'tabInfosBlankSlate' => array(
        'label' => __('Translate a post'),
    ),
    'actions' => array(
        'visualise' => function($blog) {
            return array(
                'label' => __('Visualise'),
                'action' => array(
                    'openWindow' => $blog->first_url() . '?_preview=1',
                ),
                'iconClasses' => 'nos-icon16 nos-icon16-eye',
            );
        }
    ),
    'views' => array(
        'delete' => 'noviusos_blog::blog_delete_popup'
    )
);