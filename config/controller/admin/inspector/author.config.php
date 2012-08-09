<?php

$config = array(
);

$base = \Config::load('noviusos_blognews::controller/admin/inspector/author', true);
return array_merge($base, $config);
