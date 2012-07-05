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

class Controller_Admin_Form extends \Nos\Controller_Admin_Application {

    public function action_crud($id = null) {
        $blog = $id === null ? Model_Blog::forge() : Model_Blog::find($id);
	    return \View::forge('nos::form/layout_languages', array(
		    'item' => $blog,
		    'selected_lang' => \Input::get('lang', $blog === null ? null : $blog->get_lang()),
		    'url_blank_slate' => 'admin/noviusos_blog/form/blank_slate',
		    'url_form' => 'admin/noviusos_blog/form/form',
	    ) , false);
    }

    public function action_blank_slate($id = null) {
        $blog = $id === null ? Model_Blog::forge() : Model_Blog::find($id);
        return \View::forge('nos::form/layout_blank_slate', array(
            'item'      => $blog,
            'lang'      => \Input::get('lang', ''),
            'common_id' => \Input::get('common_id', ''),
            'item_text' => __('post'),
            'url_form'  => 'admin/noviusos_blog/form/form',
            'url_crud'  => 'admin/noviusos_blog/form/crud',
            'tabInfos' => array(
                'label'   =>  __('Add a post'),
                'iconUrl' => 'static/apps/noviusos_blog/img/16/blog.png',
            ),
        ), false);
    }

    public function action_form($id = null) {

        $date = new \Date();
        $date = $date->format('%Y-%m-%d %H:%M:%S');

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
                $blog->tags = $object_from->tags;

                //$blog->wysiwygs = new \Nos\Orm\Model_Wysiwyg_Provider($blog);
                //\Debug::dump($blog->wysiwygs->content);

                //$blog->wysiwygs->content = $object_from->wysiwygs->content; //$wysiwyg;
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

        $fieldset = \Fieldset::build_from_config($fields, $blog, array(
            'success' => function($object, $data) use ($is_new, $blog) {
                $return = array(
                    'notify' =>  $is_new ?  __('Post successfully added.') : __('Post successfully saved.'),
                    'dispatchEvent' => array(
                        'name' => get_class($blog),
                        'action' => $is_new ? 'insert' : 'update',
                        'id' => $blog->blog_id,
                        'lang_common_id' => $blog->blog_lang_common_id,
                        'lang' => $blog->blog_lang,
                    ),
                );
                if ($is_new) {
                    $return['replaceTab'] = 'admin/noviusos_blog/form/crud/'.$object->blog_id;
                }
                return $return;
            },
        ));

        $fieldset->js_validation();

        $return = '';
        if ($blog::behaviours('Nos\Orm_Behaviour_Sharable')) {
            $return .= (string) \Request::forge('nos/admin/datacatcher/form')->execute(array($blog));
        }

        $return .= (string) \View::forge('noviusos_blog::form/form', array(
            'blog'     => $blog,
            'fieldset' => $fieldset,
            'lang'     => $blog->blog_lang
        ), false);

        return $return;
    }
}