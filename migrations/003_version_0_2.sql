/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

ALTER TABLE `nos_blog_category` CHANGE `cat_lang` `cat_context` VARCHAR( 25 ) NOT NULL, CHANGE `cat_lang_common_id` `cat_context_common_id` INT( 11 ) NOT NULL, CHANGE `cat_lang_is_main` `cat_context_is_main` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `nos_blog_post` CHANGE `post_lang` `post_context` VARCHAR( 25 ) NOT NULL, CHANGE `post_lang_common_id` `post_context_common_id` INT( 11 ) NOT NULL, CHANGE `post_lang_is_main` `post_context_is_main` TINYINT( 1 ) NOT NULL DEFAULT '0';

UPDATE `nos_blog_category` SET `cat_context` = CONCAT('main::', `cat_context`);
UPDATE `nos_blog_post` SET `post_context` = CONCAT('main::', `post_context`);
