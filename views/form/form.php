<?php
$fieldset->populate_with_instance($item);
$fieldset->form()->set_config('field_template',  "\t\t<tr><th class=\"{error_class}\">{label}{required}</th><td class=\"{error_class}\">{field} {error_msg}</td></tr>\n");

foreach ($fieldset->field() as $field) {
    if ($field->type == 'checkbox') {
        $field->set_template('{field} {label}');
    }
}

$fieldset->field('blog_summary')->set_template('<td class="row-field">{field}</td>');
$fieldset->field('author->user_fullname')->set_template('<p>{label} {field}</p>');
$fieldset->field('blog_read')->set_template('{label} {field} times');
$fieldset->field('wysiwygs->content->wysiwyg_text')->set_template('{field}');
$fieldset->field('blog_tags')->set_template('{field}');
$fieldset->field('blog_categories')->set_template('{field}');
$fieldset->field('blog_virtual_name')->set_template('{label}{required} <div class="table-field">{field} <span>&nbsp;.html</span></div>');
//\Debug::dump($fieldset->field('wysiwygs->content'));
//echo $fieldset->field('wysiwygs->content')->forge();
//
?>

<?= $fieldset->open('admin/noviusos_blog/form/form'.($item->is_new() ? '' : '/'.$item->blog_id)); ?>
<?= View::forge('form/layout_standard', array(
    'fieldset' => $fieldset,
    'fieldset' => $fieldset,
    'object' => $item,
    'medias' => array('medias->thumbnail->medil_media_id'),
    'title' => 'blog_title',
    'id' => 'blog_id',
    'medias' => array(),
    'large' => true,

    'save' => 'save',

    'subtitle' => array('blog_summary'),

    'content' => View::forge('form/expander', array(
        'title'   => __('Content'),
        'nomargin' => true,
        'content' => $fieldset->field('wysiwygs->content->wysiwyg_text'),
        'options' => array(
            'allowExpand' => false,
        ),
    ), false),

    'menu' => array(
        // user_fullname is not a real field in the database
        'Meta' => array('author->user_fullname', 'blog_author', 'blog_created_at', 'blog_read'),
        __('URL (post address)') => array('blog_virtual_name'),
        'Categories' => array('blog_categories'),
        'Tags' => array('blog_tags'),
    ),
), false); ?>
<?= $fieldset->close(); ?>
<script type="text/javascript">
	require(['jquery-nos-ostabs'], function ($nos) {
		$nos(function () {
			var tabInfos = {
				label : <?= \Format::forge()->to_json(isset($item) ? $item->blog_title : 'Add a blog post') ?>,
				iconUrl : 'static/apps/noviusos_blog/img/16/blog.png',
				url : 'admin/noviusos_blog/form/crud/<?= empty($item) ? '' : '/'.$item->blog_id ?>'
			};
<?php
	if (!empty($item)) {
?>
			tabInfos.actions = [
				{
					label : <?= json_encode(_('Visualise')) ?>,
					click : function() {
						window.open(<?= json_encode($item->first_url()) ?> + '?_preview=1');
					},
					iconClasses : 'nos-icon16 nos-icon16-eye'
				}
			];
<?php
}

?>
			var $el = $nos('#<?= $fieldset->form()->get_attribute('id') ?>');
			$el.onShow('bind', function() {
				$el.tab('update', tabInfos);
			});
		});
	});
</script>
