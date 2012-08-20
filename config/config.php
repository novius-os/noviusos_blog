<?php
$base = \Config::load('noviusos_blognews::config', true);
$base['icons']['64'] = 'static/apps/noviusos_blog/img/blog-64.png';
$base['icons']['32'] = 'static/apps/noviusos_blog/img/blog-32.png';
$base['icons']['16'] = 'static/apps/noviusos_blog/img/blog-16.png';
$base['application_name'] = 'Blog';
return $base;
