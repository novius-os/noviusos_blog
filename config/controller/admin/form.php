<?php
return array(
    'views' => array(
        'edit' => 'noviusos_blog::form/edit',
    ),
    'fields' => function() {
        return array (
            'blog_id' => array (
                'label' => 'Id: ',
                'widget' => 'text',
                'editable' => false,
            ),
            'blog_publication_start' => array (
                'label' => 'Published',
                'form' => array(
                    'type' => 'checkbox',
                    'value' => isset($object) && $object->blog_publication_start ? $object->blog_publication_start : \Date::forge(strtotime('now'))->format('mysql'),
                ),
            ),
            'blog_title' => array (
                'label' => 'Title: ',
                'form' => array(
                    'type' => 'text',
                ),
            ),
            'blog_author' => array(
                'label' => 'Alias: ',
                'form' => array(
                    'type' => 'text',
                ),
            ),
            'blog_virtual_name' => array(
                'label' => 'URL: ',
                'form' => array(
                    'type' => 'text',
                    'size' => 20,
                ),
                'validation' => array(
                    'required',
                    'min_length' => array(2),
                ),
            ),
            'author->user_name' => array(
                'label' => 'Author: ',
                'widget' => 'text',
                'editable' => false,
            ),
            'wysiwygs->content->wysiwyg_text' => array(
                'label' => 'Contenu',
                'widget' => 'wysiwyg', //wysiwyg
                'form' => array(
                    'style' => 'width: 100%; height: 500px;',
                    ),
            ),
            'medias->thumbnail->medil_media_id' => array(
                'label' => '',
                'widget' => 'media', //media
                'form' => array(
                    'title' => 'Thumbnail',
                ),
            ),
            'blog_created_at' => array(
                'label' => 'Created at:',
                'widget' => 'date_picker', //date_picker
            ),
            'blog_read' => array(
                'label' => 'Read',
                'form' => array(
                    'type' => 'text',
                    'size' => '4',
                ),
            ),
            'blog_tags' => array(
                'label' => 'Tags',
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
                    $tags_objs = \Nos\Blog\Model_Tag::find('all', array('where' => array(array('tag_label', 'IN', array_keys($tags)))));

                    $object->tags = array();

                    foreach ($tags_objs as $obj) {
                        unset($tags[$obj->tag_label]);
                        $object->tags[] = $obj;
                    }

                    foreach ($tags as $tag) {
                        $tag_obj = new \Nos\Blog\Model_Tag(array('tag_label' => $tag));
                        //$tag_obj->save();
                        $object->tags[] = $tag_obj;
                    }

                    //$object->tags[] = new Model_Tag(array('blgt_tag_id' => ))
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
                    'value' => 'Save',
                    'class' => 'primary',
                    'data-icon' => 'check',
                ),
            ),
        );
    }
)
?>
