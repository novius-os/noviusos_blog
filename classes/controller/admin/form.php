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

    public function action_crud($id = null) {
        $blog = $id === null ? null : Model_Blog::find($id);
	    return \View::forge('nos::form/layout_languages', array(
		    'item' => $blog,
		    'selected_lang' => $blog === null ? null : $blog->get_lang(),
		    'url_blank_slate' => 'admin/noviusos_blog/form/blank_slate',
		    'url_form' => 'admin/noviusos_blog/form/form',
	    ) , false);
    }

    public function action_blank_slate($id = null) {
        $blog = $id === null ? null : Model_Blog::find($id);
        return \View::forge('nos::form/layout_blank_slate', array(
            'item'      => $blog,
            'lang'      => \Input::get('lang', ''),
            'common_id' => \Input::get('common_id', ''),
            'item_text' => __('post'),
            'url_form'  => 'admin/noviusos_blog/form/form',
        ), false);
    }

    public function action_form($id = null) {

        $date = new \Date();
        $date = $date->format('%Y-%m-%d');

        if ($id === null) {
            $blog = Model_Blog::forge();
            $blog->author = \Session::user();
            $blog->blog_lang = 'fr_FR'; // default selected language...
            $blog->blog_created_at = $date;
        } else {
            $blog = Model_Blog::find($id);
        }

        $is_new = $blog->is_new();


        if ($is_new) {
            $create_from_id = \Input::get('create_from_id', 0);
            if (empty($create_from_id)) {
                $blog                 = Model_Blog::forge();
                $blog->blog_lang_common_id = \Input::get('common_id');
            } else {
                $object_from = Model_Blog::find($create_from_id);
                $blog      = clone $object_from;
            }
            $blog->blog_lang = \Input::get('lang');
            $blog->author = \Session::user();
            $blog->blog_created_at = $date;
        }


        $fields = $this->config;
        \Arr::set($fields, 'author->user_fullname.form.value', $blog->author->fullname());

        if ($is_new || \Input::post('blog_lang', false) != false) {
            $fields = \Arr::merge($fields, array(
                'blog_lang' => array(
                    'form' => array(
                        'type' => 'hidden',
                        'value' => \Input::get('lang'),
                    ),
                ),
                'blog_lang_common_id' => array(
                    'form' => array(
                        'type' => 'hidden',
                        'value' => $blog->blog_lang_common_id,
                    ),
                ),
                'save' => array(
                    'form' => array(
                        'value' => __('Add'),
                    ),
                ),
            ));
        }

        $fieldset = static::fieldset($fields, $blog)->set_config('field_template', '<tr><th>{label}{required}</th><td class="{error_class}">{field} {error_msg}</td></tr>');

        return \View::forge('noviusos_blog::form/form', array(
            'item'     => $blog,
            'fieldset' => $fieldset,
            'lang'     => $blog->blog_lang
        ), false);
    }

    public static function fieldset($fields, $object) {

        $is_new = false;
        $fieldset = \Fieldset::build_from_config($fields, $object, array(
            'save' => function($data) use ($object, $fields) {
                //print_r($object);
                $categories = \Input::post('categories');
                if ($categories == false) {
                    $categories = array();
                }
                $object->updateCategoriesById($categories);
            },
            'before_save' => function($object, $data) use(&$is_new) {
                $is_new = $object->is_new();
            },
            'success' => function($object, $data) use (&$is_new) {
                $return = array(
                    'notify' =>  __($is_new ? 'Post successfully added.' : 'Post successfully saved.'),
                    'dispatchEvent' => 'reload.noviusos_blog',
                );
                if ($is_new) {
                    $return['replaceTab'] = 'admin/noviusos_blog/form/edit/'.$object->blog_id;
                }
                return $return;
            }
        ));

        $fieldset->js_validation();
        return $fieldset;
    }
}