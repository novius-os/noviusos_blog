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

class Widget_Categories extends \Fieldset_Field {

	protected $widget_options = array();

    public function __construct($name, $label = '', array $attributes = array(), array $rules = array(), \Fuel\Core\Fieldset $fieldset = null) {

		//$attributes['type']   = 'hidden';
		$attributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '').' blog-categories';

		if (empty($attributes['id'])) {
			$attributes['id'] = uniqid('blog_categories_');
		}
		if (!empty($attributes['widget_options'])) {
			$this->set_widget_options($attributes['widget_options']);
		}
		unset($attributes['widget_options']);

        parent::__construct($name, $label, $attributes, $rules, $fieldset);
    }

    public function set_widget_options(array $options) {
        $this->widget_options = \Arr::merge($this->widget_options, $options);
    }

    /**
     * How to display the field
     * @return type
     */
    public function build() {
		$categories_id = $this->get_value();
	    $categories_id = is_array($categories_id) ? $categories_id : array();
	    $selected = array();
	    $model = 'Nos\\Blog\\Model_Category';
	    foreach ($categories_id as $id) {
		    $selected[$model.'|'.$id] = array(
			    'id' => $id,
			    'model' => $model,
		    );
	    }

        return $this->template((string) \Request::forge('noviusos_blog/admin/inspector/category/list')->execute(array('inspector/modeltree_checkbox', array(
	        'params' => array(
		        'treeUrl' => 'admin/noviusos_blog/inspector/category/json',
		        'reloadEvent' => 'noviusos_blog_categories',
	            'input_name' => $this->get_name(),
	            'selected' => $selected,
		        'columns' => array(
			        array(
				        'dataKey' => 'title',
			        )
		        ),
                'treeOptions' => array(
                    'lang' => \Arr::get($this->widget_options, 'lang', null)
                ),
		        'height' => \Arr::get($this->widget_options, 'height', '150px'),
		        'width' => \Arr::get($this->widget_options, 'width', null),
		    ),
        )))->response());
    }
}
