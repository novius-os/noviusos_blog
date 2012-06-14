<?php
$fieldset->populate_with_instance($blog);
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
$fieldset->field('blog_virtual_name')->set_template('{label}{required} <div class="table-field">{field} <span>&nbsp;.html</span></div>');

?>

<?= $fieldset->open('admin/noviusos_blog/form/form'.($blog->is_new() ? '' : '/'.$blog->blog_id)); ?>
<?= View::forge('nos::form/layout_standard', array(
    'fieldset' => $fieldset,
    'object' => $blog,
    'title' => 'blog_title',
    //'id' => 'blog_id',
    'medias' => array(),//'medias->thumbnail->medil_media_id'),
    'large' => true,

    'save' => 'save',

    'subtitle' => array('blog_summary'),

    'content' => array(
        View::forge('form/expander', array(
            'title'   => __('Content'),
            'nomargin' => true,
            'content' => $fieldset->field('wysiwygs->content->wysiwyg_text'),
            'options' => array(
                'allowExpand' => false,
            ),
        ), false),
    ),

    'menu' => array(
        // user_fullname is not a real field in the database
        __('Meta') => array('author->user_fullname', 'blog_author', 'blog_created_at_date', 'blog_created_at_time', 'blog_read'),
        __('URL (post address)') => array('blog_virtual_name'),
        __('Tags') => array('blog_tags'),
    ),
), false); ?>
<?= $fieldset->close(); ?>
<script type="text/javascript">
	require(['jquery-nos-ostabs'], function ($nos) {
		$nos(function () {
			var tabInfos = {
				label : <?= \Format::forge()->to_json($blog->is_new()? __('Add a post') : $blog->blog_title) ?>,
				iconUrl : 'static/apps/noviusos_blog/img/16/blog.png',
				url : 'admin/noviusos_blog/form/crud/<?= empty($blog) ? '' : '/'.$blog->blog_id ?>'
			};
<?php
	if (!$blog->is_new()) {
?>
			tabInfos.actions = [
				{
					label : <?= json_encode(__('Visualise')) ?>,
					click : function() {
						window.open(<?= json_encode($blog->first_url()) ?> + '?_preview=1');
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
