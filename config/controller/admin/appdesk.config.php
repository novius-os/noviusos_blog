<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

\Nos\I18n::current_dictionary('noviusos_blog::common');

$base = \Config::load('noviusos_blognews::controller/admin/appdesk', true);

$base['i18n'] = array(
    'item' => __('post'),
    'items' => __('posts'),
    'NItems' => n__(
        '1 post',
        '{{count}} posts'
    ),
    'showNbItems' => n__(
        'Showing 1 post out of {{y}}',
        'Showing {{x}} posts out of {{y}}'
    ),
    'showNoItem' => __('No posts'),
    // Note to translator: This is the action that clears the 'Search' field
    'showAll' => __('Show all posts'),
);
return $base;
