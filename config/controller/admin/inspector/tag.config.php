<?php

$config = array(
    'query' => array(
        'model' => 'Nos\BlogNews\Blog\Model_Tag',
        'order_by' => 'tag_label',
    ),
);

$base = \Config::load('noviusos_blognews::controller/admin/inspector/tag', true);
return array_merge($base, $config);
