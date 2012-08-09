<?php
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
    'i18n' => array(
        'Posts'                 => __('Posts'),
        'Add a post'            => __('Add a post'),
        'Delete this post'      => __('Delete this post'),
    ),
);
$base = \Config::load('noviusos_blognews::controller/admin/appdesk', true);
return array_merge($base, $config);
