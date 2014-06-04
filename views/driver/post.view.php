<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

if ($item_driver->item->mitem_post_id) {
    $post = \Nos\BlogNews\Blog\Model_Post::find($item_driver->item->mitem_post_id);
    if (!empty($post)) {
        $params['text'] = e($item_driver->title());
        if (method_exists(\Nos\Nos::main_controller(), 'getUrl') &&
            \Nos\Nos::main_controller()->getUrl() === $post->url()) {
            !isset($params['class']) && $params['class'] = '';
            $params['class'] .= ' '.\Arr::get($params, 'active_class', 'active');
        }
        echo $post->htmlAnchor($params);
        return;
    }
}
echo html_tag('div', $params, e($item_driver->title()));
