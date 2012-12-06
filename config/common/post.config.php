<?php
$base = \Config::load('noviusos_blognews::common/post', true);

$base['actions'] = array(
    'Nos\BlogNews\Blog\Model_Post.add' => array(
        'label' => __('Add a post'),
    ),
    'Nos\BlogNews\Blog\Model_Post.edit' => array(
        'label' => __('Edit this post'),
    ),
    'Nos\BlogNews\Blog\Model_Post.delete' => array(
        'label' => __('Delete this post'),
    ),
);

return $base;