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
$fieldset->field('blog_created_at_date')->set_template('<p>{label}<br/>{field}');
$fieldset->field('blog_created_at_time')->set_template(' {field}</p>');
$fieldset->field('blog_read')->set_template('<p>'.$fieldset->field('blog_read')->template.'</p>')
?>

<?= $fieldset->open('admin/noviusos_blog/blog/form'.($blog->is_new() ? '' : '/'.$blog->blog_id)); ?>

<?php

Event::register_function('config|noviusos_blog::views/form/form', 1, function(&$config) use ($fieldset, $blog) {
    $config['fieldset'] = $fieldset;
    $config['object']   = $blog;
    $config['content'][0]->set('content', $fieldset->field('wysiwygs->content->wysiwyg_text'));
});

$config = Config::load('noviusos_blog::views/form/form', true);


?>
<?= View::forge('nos::form/layout_standard', $config, false); ?>




<?= $fieldset->close(); ?>

<div id="<?= $uniqid_close = uniqid('close_') ?>" style="display:none;">
    <p><?= __('This item has been deleted.') ?></p>
    <p>&nbsp;</p>
    <p><button class="primary" data-icon="close" onclick="$(this).nosTabs('close');"><?= __('Close tab') ?></button></p>
</div>

<script type="text/javascript">
	require(
        ['jquery-nos-ostabs'],
        function ($) {
            $(function () {
                var tabInfos = <?= \Format::forge()->to_json($tabInfos) ?>;

                var $container = $('#<?= $fieldset->form()->get_attribute('id') ?>');
                $container.nosOnShow('bind', function() {
                    $container.nosTabs('update', tabInfos);
                });
                <?php
                if  (!$blog->is_new())
                {
                    ?>
                    $container.nosListenEvent({
                        name: 'Nos\\Blog\\Model_Blog',
                        action: 'delete',
                        id: '<?= $blog->blog_id ?>'
                    }, function() {
                        var $close = $('#<?= $uniqid_close ?>');
                        $close.show().nosFormUI();
                        $container.nosDialog({
                            title: <?= Format::forge()->to_json(__('Bye bye')) ?>,
                            content: $close,
                            width: 300,
                            height: 130,
                            close: function() {
                                $container.nosTabs('close');
                            }
                        });
                    });
                    <?php
                }
                ?>
                });
        });
</script>
