<?php
return array (
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
    ),
    'blog_created_at_date' => array(
        'label' => __('Created on:'),
        'widget' => 'Nos\Widget_Date_Picker',
        'dont_save' => true,
    ),
    'blog_created_at_time' => array(
        'label' => __('Created time:'),
        'widget' => 'Nos\Widget_Time_Picker',
        'dont_save' => true,
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
