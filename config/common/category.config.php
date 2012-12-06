<?php
$base = \Config::load('noviusos_blognews::common/category', true);
$base['actions'] = array(
    'Nos\\BlogNews\\Blog\\Model_Category.add' => array(
        'label' => __('Add a category'),
    ),
);
return $base;