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
		'model' => 'Nos\Model_User',
		'order_by' => \DB::expr('CONCAT(COALESCE(user_firstname, ""), user_name)'),
	),
	'dataset' => array(
		'id' => 'user_id',
		'title' => function($object) {
			return $object->fullname();
		},
	),
);