<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

\Module::load('noviusos_blognews');

$configFiles = array(
    'config',
    'controller/front',
    'controller/admin/appdesk',
    'controller/admin/application',
    'controller/admin/category',
    'controller/admin/post',
    'controller/admin/tag',
    'controller/admin/inspector/author',
    'controller/admin/inspector/category',
    'controller/admin/inspector/tag',
    'common/post',
    'common/tag',
    'model/admin/category',
);

$namespace = 'Nos\\BlogNews\Blog';
$application_name = 'noviusos_blog';
$icon = 'blog';

foreach ($configFiles as $configFile) {
    \Event::register_function('config|noviusos_blog::'.$configFile, function(&$config) use ($namespace, $application_name, $icon) {
        $config = \Config::placeholderReplace($config, array(
            'namespace' => $namespace,
            'application_name' => $application_name,
            'icon' => $icon,
        ), false);
    });
}