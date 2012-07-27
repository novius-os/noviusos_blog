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
	'query' => array(
		'model' => 'Nos\Blog\Model_Category',
		'order_by' => 'blgc_title',
	),
	'dataset' => array(
		'id' => 'blgc_id',
		'title' => 'blgc_title',
	),
	'views' => array(
		'delete' => 'noviusos_blog::category_delete_popup'
	),
	'models' => array(
		array(
			'model' => 'Nos\Blog\Model_Category',
			'order_by' => 'blgc_id',
			'childs' => array('Nos\Blog\Model_Category'),
			'dataset' => array(
				'id'    => 'blgc_id',
				'title' => 'blgc_title',
			),
		),
	),
	'roots' => array(
		array(
			'model' => 'Nos\Blog\Model_Category',
			'where' => array(array('blgc_parent_id', 'IS', \DB::expr('NULL'))),
			'order_by' => 'blgc_id',
		),
	),    
);
