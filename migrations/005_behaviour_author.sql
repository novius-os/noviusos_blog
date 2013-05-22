ALTER TABLE `nos_blog_post`
  ADD `post_updated_by_id` INT UNSIGNED NULL AFTER `post_updated_at`;

ALTER TABLE `nos_blog_category`
  ADD `cat_created_by_id`  INT UNSIGNED NULL AFTER `cat_updated_at` ,
  ADD `cat_updated_by_id`  INT UNSIGNED NULL AFTER `cat_created_by_id`;

