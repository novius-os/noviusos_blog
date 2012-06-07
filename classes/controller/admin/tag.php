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

use Nos\Controller;
use Fuel\Core\View;

class Controller_Admin_Tag extends Controller {

    public function action_delete($id) {
        $tag = Model_Tag::find($id);
        return View::forge($this->config['views']['delete'], array('tag' => $tag));
    }

    public function action_delete_confirm() {

        $success = false;

        $tag = Model_Tag::find(\Input::post('id'));
        if ($tag) {
            $tag->delete();
            $success = true;
        }


        $this->response(array(
            'notify' => __('The tag has successfully been deleted !'),
            'success' => $success,
        ));
    }
}