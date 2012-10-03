<?php
\Module::load('noviusos_blognews');

$configFiles = array(
    'config',
    'controller/front',
    'controller/admin/appdesk',
    'controller/admin/category',
    'controller/admin/post',
    'controller/admin/tag',
    'controller/admin/inspector/author',
    'controller/admin/inspector/category',
    'controller/admin/inspector/tag',
    'model/admin/post',
    'model/admin/tag',
    'model/admin/category',
);

$namespace = 'Nos\\BlogNews\Blog';
$application_name = 'noviusos_blog';

foreach ($configFiles as $configFile) {
    \Event::register_function('config|noviusos_blognews::'.$configFile, function(&$config) use ($namespace, $application_name) {
        $config = \Config::placeholder_replace($config, array('namespace' => $namespace, 'application_name' => $application_name));
    });
}