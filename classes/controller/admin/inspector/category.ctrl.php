<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Nos\Blog;

class Controller_Admin_Inspector_Category extends \Nos\Controller_Inspector_Modeltree {
    
    public function action_delete($id) {
        $category = Model_Category::find($id);
        return View::forge($this->config['views']['delete'], array('category' => $category));
    }

    public function action_delete_confirm() {

        $success = false;

        $category = Model_Category::find(\Input::post('id', 0));
        if ($category) {
            $category->delete();
            $success = true;
        }


        $this->response(array(
            'notify' => __('The category has successfully been deleted !'),
            'success' => $success,
        ));
    }
}
