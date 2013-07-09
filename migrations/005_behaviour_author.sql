/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

ALTER TABLE `nos_blog_post`
  ADD `post_updated_by_id` INT UNSIGNED NULL AFTER `post_updated_at`;

ALTER TABLE `nos_blog_category`
  ADD `cat_created_by_id`  INT UNSIGNED NULL AFTER `cat_updated_at` ,
  ADD `cat_updated_by_id`  INT UNSIGNED NULL AFTER `cat_created_by_id`;

