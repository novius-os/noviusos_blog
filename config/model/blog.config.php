<?php
return array(
    'behaviours' => array (
        'Nos\Orm_Behaviour_Sharable' => array(
            'data' => array(
                \Nos\DataCatcher::TYPE_TITLE => array(
                    'value' => 'blog_title',
                    'useTitle' => __('Title'),
                ),
                /*\Nos\DataCatcher::TYPE_URL => array(
                    'value' => function($blog) {
                        return $blog->first_url();
                    },
                    'options' => function($blog) {
                        $urls = array();
                        foreach ($blog->_possible_url() as $possible)
                        {
                            $urls[$possible['page_id'].'::'.$possible['itemUrl']] = $possible['url'];
                        }
                        return $urls;
                    },
                    'useTitle' => __('Url'),
                )*/
            ),
            'data_catchers' => array(
                array(
                    'data_catcher' => 'rss_item',
                    'title' => __('RSS Post item'),
                ),
                array(
                    'data_catcher' => 'rss_channel',
                    'title' => __('RSS Post channel comments'),
                ),
            ),
        ),
    ),
);