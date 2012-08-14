<?php
return array(
    'behaviours' => array (
        'Nos\Orm_Behaviour_Sharable' => array(
            'data' => array(
                \Nos\DataCatcher::TYPE_TITLE => array(
                    'value' => 'post_title',
                    'useTitle' => __('Title'),
                ),
                \Nos\DataCatcher::TYPE_URL => array(
                    'value' => function($post) {
                        return $post->url_canonical();
                    },
                    'options' => function($post) {
                        $urls = array();
                        foreach ($post->urls() as $possible)
                        {
                            $urls[$possible['page_id'].'::'.$possible['itemUrl']] = $possible['url'];
                        }
                        return $urls;
                    },
                    'useTitle' => __('Url'),
                ),
                \Nos\DataCatcher::TYPE_TEXT => array(
                    'value' => function($post) {
                        return $post->post_summary;
                    },
                    'useTitle' => __('Description'),
                ),
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