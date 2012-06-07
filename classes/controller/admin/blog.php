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

class Controller_Admin_Blog extends Controller {

    public function action_delete($blog_id) {
        $blog = Model_Blog::find($blog_id);
        return View::forge($this->config['views']['delete'], array('blog' => $blog));
    }

    public function action_delete_confirm() {

        $success = false;

        $billet = Model_Blog::find(\Input::post('id'));
        if ($billet) {
            $billet->delete();
            $success = true;
        }

        \Response::json(array(
            'notify' => __('The blog post has successfully been deleted !'),
            'success' => $success,
        ));
    }
}