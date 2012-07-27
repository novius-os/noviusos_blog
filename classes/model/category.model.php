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

class Model_Category extends \Nos\Orm\Model {
    protected static $_table_name = 'nos_blog_category';
    protected static $_primary_key = array('blgc_id');

    protected static $_has_one = array();

    protected static $_has_many = array(
		'children' => array(
			'key_from'       => 'blgc_id',
			'model_to'       => '\Nos\Blog\Model_Category',
			'key_to'         => 'blgc_parent_id',
			'cascade_save'   => false,
			'cascade_delete' => false,
		),
	);
    
    protected static $_many_many = array(
        'blogs' => array(
            'key_from'         => 'blgc_id',
            'key_through_from' => 'blgc_id',
            'table_through'    => 'nos_blog_category_post',
            'key_through_to'   => 'blog_id',
            'model_to'         => '\Nos\Blog\Model_Blog',
            'key_to'           => 'blog_id',
            'cascade_save'     => false,
            'cascade_delete'   => false,
        ),
    );
    
    protected static $_belongs_to = array(
		'parent' => array(
			'key_from'       => 'blgc_parent_id',
			'model_to'       => '\Nos\Blog\Model_Category',
			'key_to'         => 'blgc_id',
			'cascade_save'   => false,
			'cascade_delete' => false,
		),
    );
    
    protected static $_behaviours = array(
        'Nos\Orm_Behaviour_Tree' => array(
            'events' => array('before_search', 'after_delete', 'before'),
            'parent_relation' => 'parent',
            'children_relation' => 'children',
        ),
        /*'Nos\Orm_Behaviour_Sortable' => array(
            'events' => array('after_sort'),
            'sort_property' => 'cat_rank',
        ),*/
    );
    
    public function get_url($params = array()) {
	$url = isset($params['urlPath']) ? $params['urlPath'] : \Nos\Nos::main_controller()->getEnhancedUrlPath();
	$page = isset($params['page']) ? $params['page'] : 1;
        
        $titre = $this->blgc_virtual_name;
        
        // $titre = \Inflector::friendly_title($this->blgc_title, ' ', true);
        
	return $url.'category/'.$titre.($page > 1 ? '/'.$page : '').'.html';
    }
}

