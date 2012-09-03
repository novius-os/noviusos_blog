<?php
return array(
    'name'    => 'Blog v2',
    'version' => '0.02-beta203',
    'href' => 'admin/noviusos_blog/appdesk',
    'icon16'  => 'static/apps/noviusos_blog/img/blog-16.png',
    'icon64'  => 'static/apps/noviusos_blog/img/blog-64.png',
    'provider' => array(
        'name' => 'Novius OS',
    ),
    'namespace' => 'Nos\BlogNews\Blog',
    'permission' => array(

    ),
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
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-36.png',
            'previewUrl' => 'admin/noviusos_blog/application/preview',
            'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/application/popup',
                'width' => 450,
                'height' => 400,
                'ajax' => true,
            ),
            'data_catchers_added' => array(
                'posts_rss_channel' => array(
                    'data_catcher' => 'rss_channel',
                    'title' => __('RSS Post channel'),
                ),
                'comments_rss_channel' => array(
                    'data_catcher' => 'rss_channel',
                    'title' => __('RSS Comments channel'),
                ),
            ),
        ),
        'noviusos_blog2' => array(
            'title' => 'Blog 2',
            'desc'  => '',
            'urlEnhancer' => 'noviusos_blog/front/main',
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-36.png',
            'previewUrl' => 'admin/noviusos_blog/application/preview',
            /*'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/application/popup',
                'width' => 450,
                'height' => 400,
                'ajax' => true,
            ),*/
        ),
    ),
);
