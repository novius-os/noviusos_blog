<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$base = \Config::load('noviusos_blognews::controller/admin/appdesk', true);

$base['i18n'] = array(
    'item' => __('post'),
    'items' => __('posts'),
    'showNbItems' => __('Showing {{x}} posts out of {{y}}'),
    'showOneItem' => __('Showing 1 post'),
    'showNoItem' => __('No posts'),
    // Note to translator: This is the action that clears the 'Search' field
    'showAll' => __('Show all posts'),
);
return $base;
