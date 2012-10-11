<?php
$base = \Config::load('noviusos_blognews::controller/admin/post', true);
\Arr::set($base, 'tab.iconUrl', 'static/apps/noviusos_blog/img/blog-16.png');
return $base;