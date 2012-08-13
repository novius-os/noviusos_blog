<?php
return array (
    'controller_url'  => 'admin/noviusos_blog/tag',
    'model' => 'Nos\\Blog\\Model_Tag',
    'messages' => array(
        'successfully deleted' => __('The tag has successfully been deleted!'),
        'item deleted' => __('This tag has been deleted.'),
        'not found' => __('Tag not found'),
    ),
    'views' => array(
        'delete' => 'noviusos_blog::delete_popup_tag',
    ),
);