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

use View;

class Controller_Admin_Appdesk extends \Nos\Controller_Admin_Appdesk
{
    public function action_delete($blog_id)
    {
        $blog = Model_Blog::find($blog_id);
        return \View::forge($this->config['views']['delete'], array('blog' => $blog));
    }

    public function action_delete_confirm()
    {
        $dispatchEvent = null;
        $blog = Model_Blog::find(\Input::post('id', 0));
        if (!empty($blog))
        {
            $dispatchEvent = array(
                'name' => get_class($blog),
                'action' => 'delete',
                'id' => $blog->blog_id,
                'lang_common_id' => $blog->blog_lang_common_id,
                'lang' => $blog->blog_lang,
            );
            $blog->delete();
        }

        $this->response(array(
            'notify' => __('The blog post has successfully been deleted!'),
            'dispatchEvent' => $dispatchEvent,
        ));
    }
}

