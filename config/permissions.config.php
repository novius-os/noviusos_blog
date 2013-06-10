<?php

$base = \Config::load('noviusos_blognews::permissions', true);

$app_config = \Config::application('noviusos_blog');

if (!$app_config['authors']['enabled']) {
    unset($base['all']['params']['accordions']['other_authors_post']);
}

return $base;
