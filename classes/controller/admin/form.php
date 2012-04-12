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

class Controller_Admin_Form extends \Nos\Controller_Generic_Admin {


    public function action_edit($id = false) {
        $new_lang = \Input::get('new_lang', 0) == 1;

        $date = new \Date();
        $date = $date->format('%Y-%m-%d');


        if ($id === false) {
            $object = Model_Blog::forge();
            $object->author = \Session::user();
            $object->blog_lang = 'fr_FR'; // default selected language...
            $object->blog_created_at = $date;
        } else {
            $object = Model_Blog::find($id);
        }



        if ($new_lang) {
            $create_from_id = \Input::get('create_from_id', 0);
            if (empty($create_from_id)) {
                $object                 = Model_Blog::forge();
                $object->blog_lang_common_id = \Input::get('common_id');
            } else {
                $object_from = Model_Blog::find($create_from_id);
                $object      = clone $object_from;
            }
            $object->blog_lang = \Input::get('lang');
            $object->author = \Session::user();
            $object->blog_created_at = $date;
        }


        $fields = $this->config['fields']($object);

        if ($new_lang || \Input::post('blog_lang', false) != false) {
            $fields = \Arr::merge($fields, array(
                'blog_title' => array(
                    'validation' => array(
                        'required',
                        'min_length' => array(6),
                    ),
                ),
                'blog_lang' => array(
                    'form' => array(
                        'type' => 'hidden',
                        'value' => \Input::get('lang'),
                    ),
                ),
                'blog_lang_common_id' => array(
                    'form' => array(
                        'type' => 'hidden',
                        'value' => $object->blog_lang_common_id,
                    ),
                ),
                'save' => array(
                    'form' => array(
                        'value' => __('Add'),
                    ),
                ),
            ));
        }



        $fieldset = static::fieldset($fields, $object)->set_config('field_template', '<tr><th>{label}{required}</th><td class="{error_class}">{field} {error_msg}</td></tr>');

        if ($new_lang) {
            return \View::forge('noviusos_blog::form/post_edit', array(
                'item'     => $object,
                'fieldset' => $fieldset,
                'lang'     => $object->blog_lang
            ), false);
        } else {
            return \View::forge($this->config['views']['edit'], array(
                'object'   => $object,
                'fieldset' => $fieldset,
            ), false);
        }
    }

    public static function fieldset($fields, $object) {

        $fieldset = \Fieldset::build_from_config($fields, $object, array(
            'save' => function($data) use ($object, $fields) {
                //print_r($object);
                $categories = \Input::post('categories');
                if ($categories == false) {
                    $categories = array();
                }
                $object->updateCategoriesById($categories);

            }
        ));

        $fieldset->js_validation();
        return $fieldset;
    }
}