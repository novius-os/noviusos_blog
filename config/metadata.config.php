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
<<<<<<< HEAD
            'iconUrl' => 'static/apps/news/img/blog-16.png',
=======
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-36.png',
>>>>>>> 7956a030ba2977f008fc82aa85a4f2ab852595f3
            'previewUrl' => 'admin/noviusos_blog/application/preview',
            'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/application/popup',
                'width' => 450,
                'height' => 400,
                'ajax' => true,
            ),
            'models_url_enhanced' => array(
                'Nos\BlogNews\Blog\Model_Post',
            ),
            'get_url_model' => array('Nos\BlogNews\Blog\Controller_Front', 'get_url_model'),
        ),
    ),
);
