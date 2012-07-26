<?php
return array (
    'controller_url'  => 'admin/noviusos_blog/tag',
    'model' => 'Nos\\Blog\\Model_Tag',
    'messages' => array(
        'successfully deleted' => __('The tag has successfully been deleted!'),
        'you are about to delete, confim' => __('You are about to delete the tag <span style="font-weight: bold;">":title"</span>. Are you sure you want to continue?'),
        'you are about to delete' => __('You are about to delete the tag <span style="font-weight: bold;">":title"</span>.'),
        'exists in multiple lang' => __('This tag exists in <strong>{count} languages</strong>.'),
        'delete in the following languages' => __('Delete this tag in the following languages:'),
        'item deleted' => __('This tag has been deleted.'),
        'not found' => __('Tag not found'),
    ),
);