<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'name' => 'Blog post',
    'texts' => array(
        'add' => 'Add a blog post link',
        'new' => 'New blog post link',
    ),
    'icon' => 'static/apps/noviusos_blog/img/blog-16.png',

    // Allowed EAV attributes
    'attributes' => array(
        'post_id',
    ),

    'view' => 'noviusos_blog::driver/post',

    'admin' => array(
        'layout' => array(
            'standard' => array(
                'view'   => 'nos::form/accordion',
                'params' => array(
                    'accordions' => array(
                        'main' => array(
                            'fields' => array(
                                'mitem_post_id',
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'view'   => 'noviusos_blog::admin/driver/post',
            ),
        ),
        'fields' => array(
            'mitem_post_id' => array(
                'label' => __('Blog post:'),
                'form' => array(
                    'type' => 'hidden',
                    'class' => 'menu_item_post_id',
                ),
                'renderer' => 'Nos\Renderer_Item_Picker',
                'renderer_options' => array(
                    'model' => 'Nos\BlogNews\Blog\Model_Post',
                    'appdesk' => 'admin/noviusos_blog/appdesk',
                    'defaultThumbnail' => 'static/apps/noviusos_blog/img/blog-64.png',
                    'texts' => array(
                        'empty' => __('No blog post selected'),
                        'add' => __('Pick a blog post'),
                        'edit' => __('Pick another blog post'),
                        'delete' => __('Un-select this blog post'),
                    ),
                ),
            ),
        ),
    ),
);
