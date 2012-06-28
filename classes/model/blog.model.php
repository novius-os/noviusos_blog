<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Nos\Blog;

class Model_Blog extends \Nos\Orm\Model {
    protected static $_table_name = 'nos_blog';
    protected static $_primary_key = array('blog_id');

    protected static $_has_one = array();

    protected static $_belongs_to = array(
        'author' => array(
            'key_from' => 'blog_author_id',
            'model_to' => 'Nos\Model_User',
            'key_to' => 'user_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );

	protected static $_behaviours = array(
		'Nos\Orm_Behaviour_Translatable' => array(
			'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'before_change_parent', 'after_change_parent'),
			'lang_property'      => 'blog_lang',
			'common_id_property' => 'blog_lang_common_id',
			'single_id_property' => 'blog_lang_single_id',
            'invariant_fields'   => array(),
		),
        'Nos\Orm_Behaviour_Publishable' => array(
            'publication_bool_property' => 'blog_published',
        ),
		'Nos\Orm_Behaviour_Url' => array(),
    );

    protected static $_many_many = array(
        'tags' => array(
            'key_from'         => 'blog_id',
            'key_through_from' => 'blgt_blog_id',
            'table_through'    => 'nos_blog_tag',
            'key_through_to'   => 'blgt_tag_id',
            'model_to'         => '\Nos\Blog\Model_Tag',
            'key_to'           => 'tag_id',
            'cascade_save'     => false,
            'cascade_delete'   => false,
        ),
    );

    protected static $_has_many = array(
        'comments' => array(
            'key_from' => 'blog_id',
            'model_to' => 'Nos\Blog\Model_Comment',
            'key_to' => 'comm_parent_id',
            'cascade_save' => false,
            'cascade_delete' => true,
            //'conditions' => array('order_by' => array('comm_created_at', 'ASC'))
        ),
    );

    public function get_possible_lang() {
        return array_keys(\Config::get('locales'));
    }
}
