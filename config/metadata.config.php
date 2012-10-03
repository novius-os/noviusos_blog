<?php
return array(
    'name'    => 'Blog',
    'version' => '0.1',
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
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/noviusos_blog/appdesk',
                ),
            ),
        ),
    ),
    'enhancers' => array(
        'noviusos_blog' => array(
            'title' => 'Blog',
            'desc'  => '',
            'urlEnhancer' => 'noviusos_blog/front/main',
            'iconUrl' => 'static/apps/noviusos_blog/img/blog-16.png',
            'previewUrl' => 'admin/noviusos_blog/application/preview',
            'dialog' => array(
                'contentUrl' => 'admin/noviusos_blog/application/popup',
                'width' => 450,
                'height' => 400,
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
        64 => 'static/apps/noviusos_blog/img/blog-64.png',
        32 => 'static/apps/noviusos_blog/img/blog-32.png',
        16 => 'static/apps/noviusos_blog/img/blog-16.png',
    ),
);
