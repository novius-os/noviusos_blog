<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Nos\BlogNews\Blog;

class Controller_Admin_Post extends \Nos\BlogNews\Controller_Admin_Post
{
    protected function init_item()
    {
        parent::init_item();

        $title = \Input::get('title', null);
        $summary = \Input::get('summary', null);
        $thumbnail = \Input::get('thumbnail', null);
        if (!empty($title)) {
            $this->item->post_title = $title;
        }
        if (!empty($summary)) {
            $this->item->post_summary = $summary;
        }
        if (!empty($thumbnail)) {
            $this->item->{'medias->thumbnail->medil_media_id'} = $thumbnail;
        }
    }

    protected function get_tab_params()
    {
        $tabInfos = parent::get_tab_params();

        if ($this->is_new) {
            $params = array();
            foreach (array('title', 'summary', 'thumbnail') as $key) {
                $value = \Input::get($key, false);
                if ($value !== false) {
                    $params[$key] = $value;
                }
            }
            if (count($params)) {
                $tabInfos['url'] = $tabInfos['url'].'&'.http_build_query($params);
            }
        }

        return $tabInfos;
    }
}
