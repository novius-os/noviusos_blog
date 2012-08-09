<?php
namespace NoviusDev\BlogNews\Blog;

use \NoviusDev\Comments\Model_Comment;

class Model_Post extends \NoviusDev\BlogNews\Model_Post
{
    protected static $_primary_key = array('post_id');
    protected static $_table_name = 'nos_blog_post';
}
