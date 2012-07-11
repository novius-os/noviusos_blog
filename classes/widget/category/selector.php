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

class Widget_Category_Selector extends \Nos\Widget_Selector {

    /**
     * Add a class and an id with a prefix to the widget attributes
     * @param $attributes
     * @param $rules
     */

    public function before_construct(&$attributes, &$rules)
    {
        $attributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '').' category-selector';

        if (empty($attributes['id'])) {
            $attributes['id'] = uniqid('category_');
        }

        if(isset($attributes['widget_options']) && isset($attributes['widget_options']['parents'])){
            $this->widget_options['parents'] = $attributes['widget_options']['parents'];
            unset($attributes['widget_options']['parents']);
        }

    }

    public function build() {

        //it is necessary to construct the "selected values" array with keys written like "namespace\model|id"
        // because it must be considered as JS Object when transformed to json (see modeltree_checkbox)
        // and this is the syntax used in this widget.
        $ids = (array)$this->value;
        $selected = array();
        $pre_selected = array();
        $disabled =  array();
        if(isset($this->widget_options) && isset($this->widget_options['parents']))
        {
            $pre_selected = $this->widget_options['parents'];
            unset($this->widget_options['parents']);
        }
        foreach($ids as $id => $value)
        {
            $selected['Nos\Blog\Model_Category|'.$id] = array(
                'id' => $id,
                'model' => 'Nos\Blog\Model_Category',
            );
            if(in_array($id, $pre_selected)){
                $disabled['Nos\Blog\Model_Category|'.$id] = array(
                    'id' => $id,
                    'model' => 'Nos\Blog\Model_Category',
                );
            }

        }
        return $this->template(static::widget(array(
            'input_name' => $this->name,
            'selected' => $selected,
            'disabled' => $disabled,
            'treeOptions' => array(
                'lang' => \Arr::get($this->widget_options, 'lang', null),
            ),
            'height' => \Arr::get($this->widget_options, 'height', '150px'),
            'width' => \Arr::get($this->widget_options, 'width', null),
        )));
    }

    /**
     * Construct the radio selector widget
     * When using a fieldset,
     * build() method should be overwritten to call the template() method on widget() response
     * @static
     * @abstract
     * @param array $options
     */

    public static function widget($options = array(), $attributes = array()) {
        $options = \Arr::merge(array(
            'treeUrl' => 'admin/noviusos_blog/inspector/category/json',
//            'reloadEvent' => 'Nos\\blog\\Model_Category',
            'input_name' => null,
            'selected' => array(
            ),
            'disabled' => array(

            ),
            'columns' => array(
                array(
                    'dataKey' => 'title',
                )
            ),
            'treeOptions' => array(
                'lang' => null
            ),
            'height' => '150px',
            'width' => null,
        ), $options);

        return (string) \Request::forge('noviusos_blog/admin/inspector/category/list')->execute(
            array(
                'inspector/modeltree_checkbox',
                array(
                    'attributes' => $attributes,
                    'params' => $options,
                )
            )
        )->response();
    }
     
}
