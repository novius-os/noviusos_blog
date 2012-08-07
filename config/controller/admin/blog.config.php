<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'controller_url'  => 'admin/noviusos_blog/blog',
    'model' => 'Nos\\Blog\\Model_Blog',
    'messages' => array(
        'successfully added' => __('Post successfully added.'),
        'successfully saved' => __('Post successfully saved.'),
        'successfully deleted' => __('The post has successfully been deleted!'),
        'you are about to delete, confim' => __('You are about to delete the post <span style="font-weight: bold;">":title"</span>. Are you sure you want to continue?'),
        'you are about to delete' => __('You are about to delete the post <span style="font-weight: bold;">":title"</span>.'),
        'exists in multiple lang' => __('This post exists in <strong>{count} languages</strong>.'),
        'delete in the following languages' => __('Delete this post in the following languages:'),
        'item deleted' => __('This post has been deleted.'),
        'not found' => __('Post not found'),
        'blank_state_item_text' => __('post'),
    ),
    'tab' => array(
        'iconUrl' => 'static/apps/noviusos_blog/img/16/blog.png',
        'labels' => array(
            'insert' => __('Add a post'),
            'blankSlate' => __('Translate a post'),
        ),
    ),
    'layout' => array(
        'title' => 'blog_title',
        'medias' => array(),
        'large' => true,
        'save' => 'save',
        'subtitle' => array('blog_summary'),
        'content' => array(
            'content' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Content'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => false,
                    ),
                    'content' => array(
                        'view' => 'nos::form/fields',
                        'params' => array(
                            'fields' => array(
                                'wysiwygs->content->wysiwyg_text',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'menu' => array(
            'accordion' => array(
                'view' => 'nos::form/accordion',
                'params' => array(
                    'accordions' => array(
                        'meta' => array(
                            'title' => __('Meta'),
                            'field_template' => '{field}',
                            'fields' => array('author->user_fullname', 'blog_author', 'blog_created_at_date', 'blog_created_at_time', 'blog_read'),
                        ),
                        'url' => array(
                            'title' => __('URL (post address)'),
                            'fields' => array('blog_virtual_name'),
                        ),
                        'tags' => array(
                            'title' => __('Tags'),
                            'fields' => array('blog_tags'),
                        ),
                        'categories' => array(
                            'title' => __('Categories'),
                            'fields' => array('categories'),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'fields' => array(
        'blog_id' => array (
            'label' => __('Id: '),
            'widget' => 'Nos\Widget_Text',
            'editable' => false,
        ),
        'blog_title' => array (
            'label' => __('Title'),
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
                'min_length' => array(2),
            ),
        ),
        'blog_summary' => array (
            'label' => __('Summary'),
            'form' => array(
                'type' => 'textarea',
                'rows' => '6',
            ),
        ),
        'blog_author' => array(
            'label' => __('Alias: '),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'blog_virtual_name' => array(
            'label' => __('URL: '),
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
                'min_length' => array(2),
            ),
        ),
        'author->user_fullname' => array(
            'label' => __('Author: '),
            'widget' => 'Nos\Widget_Text',
            'editable' => false,
        ),
        'wysiwygs->content->wysiwyg_text' => array(
            'label' => __('Content'),
            'widget' => 'Nos\Widget_Wysiwyg',
            'form' => array(
                'style' => 'width: 100%; height: 500px;',
            ),
        ),
        'medias->thumbnail->medil_media_id' => array(
            'label' => '',
            'widget' => 'Nos\Widget_Media',
            'form' => array(
                'title' => 'Thumbnail',
            ),
        ),
        'blog_created_at' => array(
            'form' => array(
                'type' => 'text',
            ),
            'populate' => function($item) {
                if (\Input::method() == 'POST') {
                    return \Input::post('blog_created_at_date').' '.\Input::post('blog_created_at_time').':00';
                }
                return $item->blog_created_at;
            }
        ),
        'blog_created_at_date' => array(
            'label' => __('Created on:'),
            'widget' => 'Nos\Widget_Date_Picker',
            'dont_save' => true,
            'populate' => function($item) {
                return \Date::create_from_string($item->blog_created_at, 'mysql')->format('%Y-%m-%d');
            }
        ),
        'blog_created_at_time' => array(
            'label' => __('Created time:'),
            'widget' => 'Nos\Widget_Time_Picker',
            'dont_save' => true,
            'populate' => function($item) {
                return \Date::create_from_string($item->blog_created_at, 'mysql')->format('%H:%M');
            }
        ),
        'blog_read' => array(
            'label' => __('Read'),
            'form' => array(
                'type' => 'text',
                'size' => '4',
            ),
        ),
        'blog_tags' => array(
            'label' => __('Tags'),
            'populate' => function($object) {
                $tags = Arr::assoc_to_keyval($object->tags, 'id', 'tag_label');
                return implode(', ', array_values($tags));
            },
            'before_save' => function($object, $data) {
                $tags_from = str_replace(' ', ',', $data['blog_tags']);
                $tags_from = explode(',', $tags_from);
                $tags = array();
                foreach ($tags_from as $tag) {
                    if (!empty($tag)) {
                        $tags[$tag] = $tag;
                    }
                }
                $object->tags = array();
                if (!count($tags)) {
                    return;
                }

                $object->tags = \Nos\Blog\Model_Tag::find('all', array('where' => array(array('tag_label', 'IN', array_keys($tags)))));

                foreach ($object->tags as $obj) {
                    unset($tags[$obj->tag_label]);
                }
                foreach ($tags as $tag) {
                    $tag_obj = new \Nos\Blog\Model_Tag(array('tag_label' => $tag));
                    $object->tags[] = $tag_obj;
                }
            },
            'form' => array(
                'type' => 'text',
            ),
        ),
        'categories' => array(
            'widget' => 'Nos\Blog\Widget_Category_Selector',
            'widget_options' => array(
                'width' => '250px',
                'height' => '250px',
            ),
            'label' => __(''),
            'form' => array(
            ),
            //'dont_populate' => true,
            'before_save' => function($object, $data) {
                $object->categories;//fetch et 'cree' la relation
                unset($object->categories);

                \Log::debug(print_r($data['categories'], true));
                if(!empty($data['categories']))
                {
                    foreach($data['categories'] as $cat_id)
                    {
                        if (ctype_digit($cat_id) ) {
                            $object->categories[$cat_id] = \Nos\Blog\Model_Category::find($cat_id);
                        }
                    }
                }
            },
        ),
        'save' => array(
            'label' => '',
            'form' => array(
                'type' => 'submit',
                'tag' => 'button',
                'value' => __('Save'),
                'class' => 'primary',
                'data-icon' => 'check',
            ),
        ),
    ),
);