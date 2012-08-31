<?php

    $id = uniqid('temp_');
?>
<div id="<?= $id ?>"></div>
<script type="text/javascript">
<?php
    \Config::load('noviusos_blog::config', true);
    $withAuthors = \Config::get('noviusos_blog::config.authors.enabled');
    $withTags = \Config::get('noviusos_blog::config.tags.enabled');

?>
var Noviusdev = Object();
Noviusdev.BlogNews = Object();
Noviusdev.BlogNews.withAuthors = <?=intval($withAuthors)?>;
Noviusdev.BlogNews.withTags = <?=intval($withTags)?>;

require(
    ['jquery-nos-appdesk'],
    function($) {
        $(function() {
            $.appdeskAdd("<?= $id ?>", <?= $appdesk ?>);
        });
    });
</script>
