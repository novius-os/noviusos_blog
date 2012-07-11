<?php
return array(
    'title' => 'blog_title',
    //'id' => 'blog_id',
    'medias' => array(),//'medias->thumbnail->medil_media_id'),
    'large' => true,

    'save' => 'save',

    'subtitle' => array('blog_summary'),

    'content' => array(
        View::forge('form/expander', array(
        'title'   => __('Content'),
        'nomargin' => true,
        'content' => '',
        'options' => array(
            'allowExpand' => false,
        ),
        ), false),
    ),

    'menu' => array(
    // user_fullname is not a real field in the database
    __('Meta') => array('field_template' => '{field}', 'fields' => array('author->user_fullname', 'blog_author', 'blog_created_at_date', 'blog_created_at_time', 'blog_read')),
    __('URL (post address)') => array('blog_virtual_name'),
    __('Tags') => array('blog_tags'),
    __('Categories') => array('categories'),
    ),
);