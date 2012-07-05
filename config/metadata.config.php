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
    'version' => '0.9-alpha',
    'provider' => array(
        'name' => 'Novius OS',
    ),
    'namespace' => 'Nos\Blog',
    'permission' => array(
        'icon64'  => 'static/apps/noviusos_blog/img/64/blog.png',
    ),
    'launchers' => array(
        'noviusos_blog' => array(
            'name'    => 'Blog',
            'url' => 'admin/noviusos_blog/appdesk',
            'iconUrl' => 'static/apps/noviusos_blog/img/32/blog.png',
            'icon64'  => 'static/apps/noviusos_blog/img/64/blog.png',
        ),
    ),
    'enhancers' => array(
        'noviusos_blog' => array(
            'title' => 'Blog',
            'desc'  => '',
	        //'enhancer' => 'noviusos_blog/front',
            'urlEnhancer' => 'noviusos_blog/front/main',
            'iconUrl' => 'static/apps/noviusos_blog/img/16/blog.png',
            'previewUrl' => 'admin/noviusos_blog/preview',
	        'dialog' => array(
		        'contentUrl' => 'admin/noviusos_blog/popup',
		        'width' => 450,
		        'height' => 180,
		        'ajax' => true,
	        ),
	        'models_url_enhanced' => array(
		        'Nos\Blog\Model_Blog',
	        ),
	        'get_url_model' => array('Nos\Blog\Controller_Front', 'get_url_model'),
            'data_catchers_added' => array('blog_rss_channel'),
        ),
    ),
    'models_catched' => array(
        'blog' => array('blog_rss_chanel', 'blog_rss_item'),
        'user' => array('blog_rss_chanel'),
    ),
    'data_catchers' => array(
        'blog_rss_channel' => \Nos\DataCatcher::configRssChanel(array(
            'title' => 'RSS Chanel Blog',
            'specified_models' => array('Nos\Blog\Model_Blog'),
        )),
        'blog_rss_item' => \Nos\DataCatcher::configRssItem(array(
            'title' => 'RSS Item Blog',
            'specified_models' => array('Nos\Blog\Model_Blog'),
        )),
    ),
);
