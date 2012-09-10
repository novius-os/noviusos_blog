<?php

namespace Nos\BlogNews\Blog;

use Asset, Format, Input, Session, View, Uri;

class Controller_Admin_Post extends \Nos\BlogNews\Controller_Admin_Post
{
    protected function form_item()
    {
        parent::form_item();
        if ($this->is_new) {
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
