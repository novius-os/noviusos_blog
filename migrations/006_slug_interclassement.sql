/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

ALTER TABLE `nos_blog_post` CHANGE `post_virtual_name` `post_virtual_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;
ALTER TABLE `nos_blog_category` CHANGE `cat_virtual_name` `cat_virtual_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;