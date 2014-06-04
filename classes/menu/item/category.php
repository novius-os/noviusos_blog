<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Nos\BlogNews\Blog;

use Nos\BlogNews\Model_Category;
use Nos\Menu\Menu_Item_Driver;

class Menu_Item_Category extends Menu_Item_Driver
{

    /**
     * @return string The item title
     */
    public function title()
    {
        if (!empty($this->item->mitem_title)) {
            return parent::title();
        }

        if ($this->item->mitem_cat_id) {
            $category = Model_Category::find($this->item->mitem_cat_id);
            if (!empty($category)) {
                return $category->cat_title;
            }
        }
        return '';
    }
}
