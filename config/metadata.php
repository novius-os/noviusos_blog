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
	'href' => 'admin/noviusos_blog/list',
	'icon64'  => 'static/apps/noviusos_blog/img/64/blog.png',
    'provider' => array(
        'name' => 'Novius OS',
    ),
    'launchers' => array(
        'blog' => array(
            'name'    => 'Blog',
            'url' => 'admin/noviusos_blog/list',
            'iconUrl' => 'static/apps/noviusos_blog/img/32/blog.png',
            'icon64'  => 'static/apps/noviusos_blog/img/64/blog.png',
        ),
    ),
    'enhancers' => array(
        'noviusos_blog' => array(
            'title' => 'Blog',
            'id'    => 'noviusos_blog',
            'rewrite_prefix' => 'blog',
            'desc'  => '',
            'enhancer' => 'noviusos_blog/front',
            'iconUrl' => 'static/apps/noviusos_blog/img/16/blog.png',
            'previewUrl' => 'admin/noviusos_blog/preview',
	        'dialog' => array(
		        'contentUrl' => 'admin/noviusos_blog/popup',
		        'width' => 450,
		        'height' => 180,
		        'ajax' => true,
	        ),
        ),
    ),
    'templates' => array(
        'blog' => array(
            'file' => 'blog',
            'title' => 'Main template',
            'cols' => 3,
            'rows' => 1,
            'layout' => array(
                'content' => '0,0,2,1',
                'right' => '2,0,1,1',
            ),
        ),
    ),
);
