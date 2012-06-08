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
	'general' => array(
		'driver' => 'select',
		'label'=> 'Title for the multiple permissions',
		'driver_config' => array(
			'choices' => array(
				'read' => array(
					'title' => 'Read access',
					'icon'  => 'static/novius-os/admin/novius-os/img/icons/eye.png',
					'granted_by' => array('full_access'),
				),
				'write' => array(
					'title' => 'Create new posts and edit them',
					'icon'  => '',
					'granted_by' => array('full_access'),
				),
				'full_access' => array(
					'title' => 'Edit posts from everyone',
					'icon'  => '',
				),
			),
		),
	),
	'unique' => array(
		'driver' => 'radio',
		'label' => 'Title for the unique permission',
		'driver_config' => array(
			'choices' => array(
				'read' => array(
					'title' => 'Read access',
					'icon'  => 'static/novius-os/admin/novius-os/img/icons/eye.png',
					'granted_by' => array('full_access'),
				),
				'write' => array(
					'title' => 'Create new posts and edit them',
					'icon'  => '',
					'granted_by' => array('full_access'),
				),
			),
		),
	),
);
