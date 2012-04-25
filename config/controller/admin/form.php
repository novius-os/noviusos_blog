<?php
return array(
    'views' => array(
        'edit' => 'noviusos_blog::form/edit',
    ),
    'fields' => function() {
        return array (
            'blog_id' => array (
                'label' => __('Id: '),
                'widget' => 'Nos\Widget_Text',
                'editable' => false,
            ),
            'blog_publication_start' => array (
                'label' => __('Published'),
                'form' => array(
                    'type' => 'checkbox',
                    'value' => isset($object) && $object->blog_publication_start ? $object->blog_publication_start : \Date::forge(strtotime('now'))->format('mysql'),
                ),
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
                'widget' => 'Nos\Widget_Wysiwyg', //wysiwyg
                'form' => array(
                    'style' => 'width: 100%; height: 500px;',
                    ),
            ),
            'medias->thumbnail->medil_media_id' => array(
                'label' => '',
                'widget' => 'Nos\Widget_Media', //media
                'form' => array(
                    'title' => 'Thumbnail',
                ),
            ),
            'blog_created_at' => array(
                'label' => __('Created at:'),
                'widget' => 'Nos\Widget_Date_Picker', //date_picker
            ),
            'blog_read' => array(
                'label' => __('Read'),
                'form' => array(
                    'type' => 'text',
                    'size' => '4',
                ),
            ),
	        'blog_categories' => array(
		        'label' => '',
		        'widget' => 'Nos\Blog\Widget_Categories',
		        'widget_options' => array(
			        'width' => '100%',
			        'height' => '250px',
		        ),
		        'populate' => function($object) {
			        $categories = Arr::assoc_to_keyval($object->categories, 'blgc_id', 'blgc_id');
			        return array_values($categories);
		        },
		        'before_save' => function($object, $data) {
			        $categories_id = is_array($data['blog_categories']) ? $data['blog_categories'] : array();
			        $object->categories = array();
			        if (!count($categories_id)) {
				        return;
			        }
			        $object->categories = \Nos\Blog\Model_Category::find('all', array('where' => array(array('blgc_id', 'IN', $categories_id))));
		        },
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
        );
    }
)
?>
