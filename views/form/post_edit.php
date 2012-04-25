<?php
$fieldset->populate_with_instance($item);
$fieldset->form()->set_config('field_template',  "\t\t<tr><th class=\"{error_class}\">{label}{required}</th><td class=\"{error_class}\">{field} {error_msg}</td></tr>\n");

foreach ($fieldset->field() as $field) {
    if ($field->type == 'checkbox') {
        $field->set_template('{field} {label}');
    }
}

$fieldset->field('blog_read')->set_template('{label} {field} times');
$fieldset->field('wysiwygs->content->wysiwyg_text')->set_template('{field}');
$fieldset->field('blog_tags')->set_template('{field}');
$fieldset->field('blog_categories')->set_template('{field}');
$fieldset->field('blog_virtual_name')->set_template('{label} {field} .html');
//\Debug::dump($fieldset->field('wysiwygs->content'));
//echo $fieldset->field('wysiwygs->content')->forge();
?>

<?= $fieldset->open('admin/noviusos_blog/form/edit'.(isset($item) ? '/'.$item->blog_id : '')); ?>
<?= View::forge('form/layout_standard', array(
    'fieldset' => $fieldset,
    'object' => $item,
    'medias' => array('medias->thumbnail->medil_media_id'),
    'title' => 'blog_title',
    'id' => 'blog_id',
    'medias' => array(),
    'large' => true,

    'published' => 'blog_publication_start',
    'save' => 'save',

    'subtitle' => array(),

    'content' => View::forge('form/expander', array(
        'title'   => __('Summary'),
        'nomargin' => true,
        'content' => $fieldset->field('blog_summary')->set_template('{field}'),
    ), false).View::forge('form/expander', array(
        'title'   => __('Content'),
        'nomargin' => true,
        'content' => $fieldset->field('wysiwygs->content->wysiwyg_text'),
    ), false),

    'menu' => array(
        // user_fullname is not a real field in the database
        'Meta' => array('author->user_name', 'blog_author', 'blog_created_at', 'blog_read'),
        __('URL (post address)') => array('blog_virtual_name'),
        'Categories' => array('blog_categories'),
        'Tags' => array('blog_tags'),
    ),
), false); ?>
<?= $fieldset->close(); ?>