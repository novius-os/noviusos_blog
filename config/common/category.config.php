<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$base = \Config::load('noviusos_blognews::common/category', true);
$base['actions'] = array(
    'Nos\\BlogNews\\Blog\\Model_Category.add' => array(
        'label' => __('Add a category'),
    ),
);
return $base;