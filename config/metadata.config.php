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
    'name'    => 'Blog',
    'version' => '5 (Elche)',
    'provider' => array(
        'name' => 'Novius OS',
    ),
    'namespace' => 'Nos\BlogNews\Blog',
    'permission' => array(

    ),
    'requires' => array('noviusos_blognews', 'noviusos_comments'),
    'extends' => array('noviusos_menu'),
    'i18n_file' => 'noviusos_blog::metadata',
    'launchers' => array(
        'noviusos_blog' => array(
            'name'    => 'Blog',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/noviusos_blog/appdesk',
                ),
            ),
        ),
    ),
    'enhancers' => array(
        'noviusos_blog_home' => array(
            'title' => 'Links to blog posts (e.g. for side column)',
            'desc'  => '',
            'enhancer' => 'noviusos_blog/front/home',
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-16.png',
            'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/enhancer/popup',
                'width' => 370,
                'height' => 410,
                'ajax' => true,
            ),
        ),
        'noviusos_blog' => array(
            'title' => 'Blog',
            'desc'  => '',
            'urlEnhancer' => 'noviusos_blog/front/main',
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-16.png',
            'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/enhancer/popup',
                'width' => 370,
                'height' => 410,
                'ajax' => true,
            ),
        ),
    ),
    'data_catchers' => array(
        'noviusos_blog' => array(
            'title' => 'Blog',
            'description'  => '',
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-16.png',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/noviusos_blog/post/insert_update/?context={{context}}&title={{urlencode:'.\Nos\DataCatcher::TYPE_TITLE.'}}&summary={{urlencode:'.\Nos\DataCatcher::TYPE_TEXT.'}}&thumbnail={{urlencode:'.\Nos\DataCatcher::TYPE_IMAGE.'}}',
                    'label' => __('Add a post'),
                    'iconUrl' => 'static/apps/noviusos_blog/img/blog-16.png',
                ),
            ),
            'onDemand' => true,
            'specified_models' => false,
            'required_data' => array(
                \Nos\DataCatcher::TYPE_TITLE,
            ),
            'optional_data' => array(
                \Nos\DataCatcher::TYPE_TEXT,
                \Nos\DataCatcher::TYPE_IMAGE,
            ),
        ),
    ),
    'icons' => array(
        16 => 'static/apps/noviusos_blog/img/blog-16.png',
        32 => 'static/apps/noviusos_blog/img/blog-32.png',
        64 => 'static/apps/noviusos_blog/img/blog-64.png',
    ),
);
