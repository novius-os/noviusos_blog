<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

?>
<div id="<?= $uniqid = uniqid('id_') ?>"></div>
<script type="text/javascript">
    require(['jquery-nos-ostabs'], function ($nos) {
        $nos(function () {
	        $nos('#<?= $uniqid ?>').tab('update', {
                label : <?= \Format::forge()->to_json(isset($object) ? $object->blog_title : 'Add a blog post') ?>,
                iconUrl : 'static/apps/noviusos_blog/img/16/blog.png',
		        actions : [
			        {
				        label : <?= json_encode(_('Visualise')) ?>,
				        click : function() {
					        window.open(<?= json_encode($object->first_url()) ?>);
				        },
				        iconClasses : 'nos-icon16 nos-icon16-eye'
			        }
		        ]
	        })
	        .remove();
        });
    });
</script>


<style type="text/css">
/* ? */
/* @todo check this */
.ui-accordion-content-active {
	overflow: visible !important;
}
</style>

<?php

echo View::forge('nos::layouts/languages', array(
    'item' => $object,
    'views' => array(
        'blank' => array(
            'location' => 'noviusos_blog::form/post_edit_blank',
            'params'   => array()
        ),
        'view' => array(
            'location' => 'noviusos_blog::form/post_edit',
            'params'   => array('fieldset' => $fieldset)
        ),
    ),
) , false);
