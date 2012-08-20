<?php
namespace Nos\BlogNews\Blog;

class Model_Tag extends \Nos\BlogNews\Model_Tag
{
    protected static $_primary_key = array('tag_id');
    protected static $_table_name = 'nos_blog_tag';
    public static function _init() {
        parent::_init();
        static::$_behaviours['Nos\Orm_Behaviour_Url']['enhancers'][] = 'noviusos_blog';
    }
}
