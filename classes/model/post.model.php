<?php
namespace Nos\BlogNews\Blog;

use \Nos\Comments\Model_Comment;

class Model_Post extends \Nos\BlogNews\Model_Post
{
    protected static $_primary_key = array('post_id');
    protected static $_table_name = 'nos_blog_post';

    public static function _init() {
        parent::_init();
        static::$_behaviours['Nos\Orm_Behaviour_Url']['urls'][] = array('Nos\BlogNews\Blog\Controller_Front', 'url_model');
    }
}
