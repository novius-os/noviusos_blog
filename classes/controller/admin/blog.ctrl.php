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

use Nos\Controller;

class Controller_Admin_Blog extends \Nos\Controller_Admin_Crud {

    protected function form_item()
    {
        parent::form_item();
        if ($this->item->is_new())
        {
            $date = new \Date();
            $date = $date->format('%Y-%m-%d %H:%M:%S');
            $this->item->blog_created_at = $date;
            $this->item->author = \Session::user();
            if ($this->item_from)
            {
                $this->item->tags = $this->item_from->tags;
            }
        }
    }

    protected function fields($fields)
    {
        $fields = parent::fields($fields);
        \Arr::set($fields, 'author->user_fullname.form.value', $this->item->author->fullname());
        return $fields;
    }

    protected function fieldset($fieldset)
    {
        $fieldset = parent::fieldset($fieldset);
        $fieldset->field('blog_summary')->set_template('<td class="row-field">{field}</td>');
        $fieldset->field('author->user_fullname')->set_template('<p>{label} {field}</p>');
        $fieldset->field('blog_read')->set_template('{label} {field} times');
        $fieldset->field('wysiwygs->content->wysiwyg_text')->set_template('{field}');
        $fieldset->field('blog_tags')->set_template('{field}');
        $fieldset->field('blog_virtual_name')->set_template('{label}{required} <div class="table-field">{field} <span>&nbsp;.html</span></div>');
        $fieldset->field('blog_created_at_date')->set_template('<p>{label}<br/>{field}');
        $fieldset->field('blog_created_at_time')->set_template(' {field}</p>');
        $fieldset->field('blog_read')->set_template('<p>'.$fieldset->field('blog_read')->template.'</p>');
        return $fieldset;
    }

    public function action_delete($blog_id)
    {
        $blog = Model_Blog::find($blog_id);
        return \View::forge($this->config['views']['delete'], array('blog' => $blog));
    }

    public function action_delete_confirm()
    {
        $dispatchEvent = null;
        $blog = Model_Blog::find(\Input::post('id', 0));
        if (!empty($blog))
        {
            $dispatchEvent = array(
                'name' => get_class($blog),
                'action' => 'delete',
                'id' => $blog->blog_id,
                'lang_common_id' => $blog->blog_lang_common_id,
                'lang' => $blog->blog_lang,
            );
            $blog->delete();
        }

        $this->response(array(
            'notify' => __('The blog post has successfully been deleted!'),
            'dispatchEvent' => $dispatchEvent,
        ));
    }
}