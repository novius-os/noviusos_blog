<?php
return array(
    'name'    => 'Blog v2',
    'version' => '0.02-beta203',
    'href' => 'admin/noviusos_blog/appdesk',
    'icon64'  => 'static/apps/noviusos_blog/img/blog-64.png',
    'provider' => array(
        'name' => 'Novius OS',
    ),
    'namespace' => 'Nos\BlogNews\Blog',
    'launchers' => array(
        'noviusos_blog' => array(
            'name'    => 'Blog',
            'url'     => 'admin/noviusos_blog/appdesk',
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-32.png',
            'icon64'  => 'static/apps/noviusos_blog/img/blog-64.png',
        ),
    ),
    'enhancers' => array(
        'noviusos_blog' => array(
            'title' => 'Blog',
            'desc'  => '',
            'urlEnhancer' => 'noviusos_blog/front/main',
            'iconUrl' => 'static/apps/news/img/blog-16.png',
            'previewUrl' => 'admin/noviusos_blog/application/preview',
            'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/application/popup',
                'width' => 450,
                'height' => 180,
                'ajax' => true,
            ),
        ),
    ),
);
