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

use Nos\Controller_Front_Application;
use Nos\Model_Page;

use Fuel\Core\Inflector;
use Fuel\Core\Str;
use Fuel\Core\View;

class Controller_Front extends Controller_Front_Application {

    /**
     * @var Nos\Pagination
     */
    public $pagination;
    public $current_page = 1;

    /**
     * @var Nos\Blog\Model_Category
     */
    public $category;

    /**
     * @var Nos\Model_User
     */
    public $author;

    /**
     * @var Nos\Blog\Model_Tag
     */
    public $tag;

    public $page_from = false;

    public static $blog_url = '';


    public function action_main($args = array()) {
        $this->default_config = \Arr::merge($this->config, \Config::get('noviusos_blog::config'), array(
			'config' => (array) $args,
		));

        $this->page_from = \Nos\Nos::main_page();

        setlocale(LC_ALL, $this->page_from->get_lang());

        \Nos\I18n::setLocale($this->page_from->get_lang());

        $this->merge_config('config');

	    $this->enhancerUrlPath = \Nos\Nos::main_controller()->enhancerUrlPath;

	    $url = \Nos\Nos::main_controller()->enhancerUrl;
        $this->config['item_per_page'] = $args['item_per_page'];

        \Nos\I18n::load('noviusos_blog::comments', 'comments');

        if (!empty($url)) {
	        $this->enhancerUrl_segments = explode('/', $url);
            $segments = $this->enhancerUrl_segments;


	        if (empty($segments[1])) {
		        $this->cache_cleanup = "blog/post/{$segments[0]}";
		        return $this->display_item($args);
            } else if ($segments[0] == 'stats') {

                $post = $this->_get_post(array(array('blog_id', $segments[1])));
                if (!empty($post)) {
                    $stats = \Session::get('noviusos_blog_stats', array());
                    if (!in_array($post->blog_id, $stats)) {
                        $post->blog_read++;
                        $post->save();
                        $stats[] = $post->blog_id;
                        \Session::set('noviusos_blog_stats', $stats);
                    }
                }
                \Nos\Tools_File::send(DOCROOT.'static/apps/noviusos_blog/img/transparent.gif');

	        } else if ($segments[0] === 'page') {
		        $this->cache_cleanup = "blog/list";
		        $this->init_pagination(empty($segments[1]) ? 1 : $segments[1]);
		        return $this->display_list_main($args);
	        } else if ($segments[0] === 'category') {
		        $this->cache_cleanup = "blog/category/{$segments[1]}";
		        $this->init_pagination(!empty($segments[2]) ? $segments[2] : 1);
		        return $this->display_list_category($args);
	        } else if ($segments[0] === 'author') {
		        $this->cache_cleanup = "blog/author/{$segments[1]}";
		        $this->init_pagination(!empty($segments[2]) ? $segments[2] : 1);
		        return $this->display_list_author($args);
	        } else if ($segments[0] === 'tag') {
		        $this->cache_cleanup = "blog/tag/{$segments[1]}";
		        $this->init_pagination(!empty($segments[2]) ? $segments[2] : 1);
		        return $this->display_list_tag($args);
	        }

	        throw new \Nos\NotFoundException();
        }

        $this->cache_cleanup = "blog/list";
        $this->init_pagination(1);
        return $this->display_list_main($args);
    }

    protected function init_pagination($page) {
        $this->current_page = $page;
        $this->pagination   = new \Nos\Pagination();
    }

    public function display_list_main($params) {

        $list = $this->_display_list('list_main');

        \Nos\Nos::main_controller()->page_title = 'Novius Labs';

        $self   = $this;
        $class = get_class($this);

        // Add surrounding stuff
        return View::forge($this->config['list_view'], array(
            'list'       => $list,
            'pagination' => $this->pagination->create_links(function($page) use ($class, $self) {
                if ($page == 1) {
                    return mb_substr($self->enhancerUrlPath, 0, -1).'.html';
                }
                return $self->enhancerUrlPath.'page/'.$page.'.html';
            }),
        ), false);
    }

    public function display_list_category($params) {

        list(,,$cat_id, $page) = $this->enhancerUrl_segments;

        $this->category = Model_Category::find($cat_id);
        $list = $this->_display_list('category');

        $class = get_called_class();
        $self  = $this;
        $url   = $this->url;

        $link_to_category = function($category, $page = 1) use($self, $url) {
            return $self::get_url_model($category, array('page' => $page, 'urlPath' => $url));
        };
        $link_pagination = function($page) use ($link_to_category, $self) {
            return $link_to_category($self->category, $page);
        };

        // Add surrounding stuff
        return View::forge($this->config['list_view'], array(
            'list'             => $list,
            'pagination'       => $this->pagination->create_links($link_pagination),
            'category'         => $this->category,
            'link_to_category' => $link_to_category,
        ), false);
    }

    public function display_list_tag($params) {

        list(, $tag) = $this->enhancerUrl_segments;
        $this->tag = Model_Tag::forge(array(
            'tag_label' => strtolower($tag),
        ));


        $class = get_called_class();
        $self  = $this;
        $url   = $this->url;

        $link_to_tag = function($tag, $page = 1) use($self, $url) {
            return $self::get_url_model($tag, array('page' => $page, 'urlPath' => $url));
        };
        $link_pagination = function($page) use ($link_to_tag, $self) {
            return $link_to_tag($self->tag, $page);
        };

        $list = $this->_display_list('tag');

        // Add surrounding stuff
        return View::forge('front/list_tag', array(
            'list'        => $list,
            'pagination'  => $this->pagination->create_links($link_pagination),
            'tag'         => $this->tag,
            'link_to_tag' => $link_to_tag,
        ), false);
    }

    public function display_list_author($user_id) {

        list(,,$user_id, $page) = $this->enhancerUrl_segments;

        $this->author = \Nos\Model_User::find($user_id);
        $list = $this->_display_list('author');

        $class = get_called_class();
        $self  = $this;
        $url   = $this->url;

        $link_to_author = function($author, $page = 1) use($self, $url) {
            return $self::get_url_model($author, array('page' => $page, 'urlPath' => $url));
        };
        $link_pagination = function($page) use ($link_to_author, $self) {
            return $link_to_author($self->author, $page);
        };

        // Add surrounding stuff
        echo View::forge($this->config['list_view'], array(
            'list'           => $list,
            'pagination'     => $this->pagination->create_links($link_pagination),
            'author'         => $this->author,
            'link_to_author' => $link_to_author,
        ), false);
    }

    /**
     * Display several items (from a list context)
     *
     * @param   string  $context = list_main | list_author | list_category | list_tag
     */
    protected function _display_list($context = 'list_main') {

        // Allow events for each or all context
        $this->trigger('display_list');
        $this->trigger("display_{$context}");


        $this->config = \Arr::merge($this->config, $this->default_config['display_list'], $this->default_config["display_{$context}"]);


        // Get the list of posts
        $query = Model_Blog::query()
                ->related(array('author'));

        $query->where(array('blog_published', true));

		$query->where(array('blog_lang', $this->page_from->page_lang));

        if (!empty($this->category)) {
            $query->where(array('categories.blgc_id', $this->category->blgc_id));
        }
        if (!empty($this->author)) {
            $query->where(array('blog_author_id', $this->author->user_id));
        }
        if (!empty($this->tag)) {
            $query->where(array('tags.tag_label', $this->tag->tag_label));
        }

        $this->pagination->set_config(array(
            'total_items'    => $query->count(),
            'per_page'       => $this->config['item_per_page'],
            'current_page'   => $this->current_page,
        ));

        $query->rows_offset($this->pagination->offset);
        $query->rows_limit((int)$this->pagination->per_page);
        //$query->group_by('blog_id');


        $query->order_by($this->config['order_by']);

        $posts = $query->get();

        // Re-fetch with a 2nd request to get all the relations (not only the filtered ones)
        if (!empty($this->category) || !empty($this->tag)) {
            $keys = array_keys((array) $posts);
            $posts = Model_Blog::query(array(
                'where' => array(
                    array('blog_id', 'IN', $keys),
                ),
                'related' => array('author', 'categories', 'tags'),
            ))->get();
        }

        // Display them
        return $this->_display_items($posts, $context);
    }

    /**
     * Display several items (from a list context)
     *
     * @param   array   $items
     * @param   string  $context = list_main | list_author | list_category | list_tag
     * @return  string  Rendered view
     */
    protected function _display_items($items, $context = 'list_main')  {

        $retrieve_stats = !empty($this->config['stats']) && $this->config['stats'];
        $comments_count = array();

        $ids = array();
        foreach ($items as $post) {
            $ids[] = $post->blog_id;
        }

        if ($retrieve_stats) {

            // Retrieve the comment counts for each post (1 request)
            $comments_count = \Db::select(\Db::expr('COUNT(comm_id) AS count_result'), 'comm_parent_id')
                    ->from(\Nos\Blog\Model_Comment::table())
                    ->and_where('comm_type', '=', 'blog')
                    ->and_where('comm_parent_id', 'in', $ids)
                    ->group_by('comm_parent_id')
                    ->execute()->as_array();
            $comments_count = \Arr::assoc_to_keyval($comments_count, 'comm_parent_id', 'count_result');

        }

        // Loop meta-data
        $length = count($items);
        $index  = 1;
        $output = array();

        // Events based on current iteration
        $this->trigger('display_list_item');
        $this->trigger("display_{$context}_item");
        $this->merge_config('display_list_item');
        $this->merge_config("display_{$context}_item");
        if (!empty($this->config['fields_views'])) {
            $this->views = static::_compute_views($this->config['fields_views']);
        }

        // Render each news
        foreach ($items as $item) {
            $this->loop = array(
                'length' => $length,
                'current' => $index,
                'first'  => $index == 1,
                'last'   => $index++ == $length,
            );

            $this->trigger('display_list_item_loop');
            $this->trigger("display_{$context}_item_loop");

            if ($this->loop['first']) {
                $this->merge_config('display_list_item_first');
                $this->merge_config("display_{$context}_item_first");
            } else {
                $this->merge_config('display_list_item_following');
                $this->merge_config("display_{$context}_item_following");
            }

            $output[] = $this->_display_item($item, array(
                'comment_count' => isset($comments_count[$item->blog_id]) ? $comments_count[$item->blog_id] : null,
            ));
        }
        return implode('', $output);
    }

    /**
     * Display a single item (outside a list context)
     *
     * @param   type  $item_id
     * @return  \Fuel\Core\View
     */
    public function display_item($args) {
        if ($this->config['use_recaptcha']) {
            \Package::load('fuel-recatpcha', APPPATH.'packages/fuel-recaptcha/');
        }

        list($item_virtual_name) = $this->enhancerUrl_segments;

        $post = $this->_get_post($item_virtual_name);

        if (empty($post)) {
            throw new \Nos\NotFoundException();
        }
        $add_comment_success = $this->_add_comment($post);

        $this->trigger('display_item');
        $this->merge_config('display_item');

        echo $this->_display_item($post, array('add_comment_success' => $add_comment_success, 'use_recaptcha' => $this->config['use_recaptcha']));
    }

    protected function _get_post($where = array()) {
        // First argument is a string => it's the virtual name
        if (!is_array($where)) {
            $where = array(array('blog_virtual_name', '=', $where));
        }

        if (!\Nos\Nos::main_controller()->is_preview) {
            $where[] = array('blog_published', '=', true);
        }
        return Model_Blog::find('first', array('where' => $where));
    }

    protected function _add_comment($post) {
        if (\Input::post('todo') == 'add_comment') {
            if (!$this->config['use_recaptcha'] || \ReCaptcha\ReCaptcha::instance()->check_answer(\Input::real_ip(), \Input::post('recaptcha_challenge_field'), \Input::post('recaptcha_response_field')))
            {
                $comm = new Model_Comment();
                $comm->comm_type = 'blog';
                $comm->comm_email = \Input::post('comm_email');
                $comm->comm_author = \Input::post('comm_author');
                $comm->comm_content = \Input::post('comm_content');
                $date = new \Fuel\Core\Date();
                $comm->comm_created_at = \Date::forge()->format('mysql');
                $comm->post = $post;
                $comm->comm_state = $this->config['comment_default_state'];
                $comm->save();

                \Cookie::set('comm_email', \Input::post('comm_email'));
                \Cookie::set('comm_author', \Input::post('comm_author'));
                return true;
            } else {
                return false;
            }
        }
        return 'none';
    }

    /**
     *  Display a single item (from any context)
     *
     * @param   \Nos\Blog\Model_Blog  $item  An instance of the model
     * @param   array                 $data  Additionnal data to pass to the view
     *  - comment_count : the number of comment for this post
     * @return  \Fuel\Core\View
     */
    protected function _display_item($item, $data = array()) {

        $data['date_format'] = $this->config['date_format'];
        $data['title_tag']   = $this->config['title_tag'];

        // Main data from model, probably not needed thanks to Orm\Observers\Typing
        $data['created_at'] = strtotime($item['blog_created_at']);

        // Additional data calculated per-item
        $data['link_to_author'] = $item->author ? self::get_url_model($item->author) : '';
        $data['link_to_item']   = self::get_url_model($item);
        $data['link_on_title']  = $this->config['link_on_title'] ? $data['link_to_item'] : false;
        $data['link_to_stats']  = self::url_stats($item, $this->enhancerUrlPath);

        $self = get_called_class();
        $url  = $this->url;
        $data['link_to_category'] = function($category, $page = 1) use($self, $url) {
            return $self::get_url_model($category, array('page' => $page, 'urlPath' => $url));
        };
        $data['link_to_tag'] = function($tag, $page = 1) use($self, $url) {
            return $self::get_url_model($tag, array('page' => $page, 'urlPath' => $url));
        };

        // Renders all the fields
        $fields = array();
        foreach (preg_split('/[\s,-]+/u', $this->config['fields']) as $field) {
            $view = isset($this->views[$field]) ? $this->views[$field] : $this->config['fields_view'];
            $data['display'] = array($field => true);
            $data['item']    = $item;
            $view = static::get_view($view);
            $view->set($data);
            $view->set('item', $item, false);
            $fields[$field] = $view;
        }
        $view = static::get_view($this->config['item_view']);
        $view->set($data + $fields, null, false);
        return $view;
    }

    public static function get_view($which) {
        // Cache views
        static $views = array();
        if (empty($views[$which])) {
            $views[$which] = View::forge($which);
        }
        // Return empty views
        return clone $views[$which];
    }

    public function action_menu($dossier_menu = false) {

        return \Nos\PubliCache::get('noviusos_blog/menu', array(
            'callback_func' => array($this, 'action_menu_execute'),
            'callback_args' => array($dossier_menu)
        ));
    }

    public function action_menu_execute($dossier_menu = false) {
        static::$blog_url = \Nos\Model_Page::get_url(2);
        self::MenuBlog($dossier_menu);
    }

    public function action_links() {

        return \Nos\PubliCache::get('noviusos_blog/links', array(
            'callback_func' => array($this, 'action_links_execute'),
        ));
    }

    public function action_links_execute() {
        static::$blog_url = \Nos\Model_Page::get_url(2);
        self::newLiens();
    }

    public function action_insert_tags() {

        return \Nos\PubliCache::get('noviusos_blog/tags', array(
            'callback_func' => array($this, 'action_insert_tags_execute'),
        ));
    }

    public function action_insert_tags_execute() {

        static::$blog_url = \Nos\Model_Page::get_url(2);
        self::EncartTags();
    }


    static function EncartTags() {
        //$nb = \Nos\Blog\Model_Tag::query();
        //$nb->select(\Db::expr('COUNT(blgt_tag) as nb'));
        $query = \Db::select(\Db::expr('tag_label AS tag'), \Db::expr('COUNT(tag_label) AS sizeof'))
                ->distinct()
                ->from('noviusos_blog_tag')
				->join('noviusos_tag')
				->on('noviusos_blog_tag.blgt_tag_id', '=' , 'noviusos_tag.tag_id');


        $nb = $query->execute()->get('sizeof');
        $tags = $query
                ->group_by('blgt_tag_id')
                ->order_by('sizeof', 'desc')
                ->limit(20)
                ->as_object()
                ->execute()
                ->as_array();

        if (!count($tags)) {
            return;
        }
        $tags = (array) $tags;

        usort($tags, function($a, $b) {
            if ($a->tag == $b->tag) {
                return 0;
            }
            return $a->tag < $b->tag ? -1 : 1;
        });
?>
<div class="cadre_tag_top"></div>
<div class="cadre" style="padding:10px 10px; background: url(static/images/blog/cadre_tag_fond.png) bottom repeat-x;">
  <h3 align="left" style="margin:0 0 10px 0; text-transform: uppercase;" ><?= __('Tags') ?></h3>
  <div style="padding:0px 5px 8px;">
<?          self::cloud($tags, 5, 'tag_poids'); ?>
  </div>
<?      if ($nb > count($tags)) { ?>
 <div align="center" style="padding-bottom:5px;"><a href="<?= static::$blog_url ?>?todo=tags"><?= __('Tous les tags') ?></a></div>
<?      } ?>
</div>
<?
    }

    static function cloud($tags, $nb_paliers, $prefixeclass) {
        $nb_paliers = $nb_paliers ? $nb_paliers : 10;
        $max        = 1;
        foreach ($tags as $tag) {
            if ($tag->sizeof > $max) {
                $max = $tag->sizeof;
            }
        }
        $nb_paliers = 5;
        foreach ($tags as $tag) {
            for ($i = 1; $i <= $nb_paliers; $i++) {
                if ($tag->sizeof <= ($i * $max) / $nb_paliers) {
                    $poids = $i;
                    break;
                }
            }
?>
    <a class="tag <?= $prefixeclass.$poids ?>" href="<?= self::get_url_model($tag->tag, array('urlPath' => static::$blog_url)) ?>"><?= $tag->tag ?></a>
<?php
        }
    }




    static function MenuBlog($dossier_menu = false) {

        $page = \Nos\Model_Page::query()
                ->where_open()
                    ->where(array('page_home', '=', '1'))
                    ->or_where(array('page_carrefour', '=', '1'))
                ->where_close()
                ->where(array('page_root_id', '=', 'fr'));
        $accueil = current($page->get());

        $page_menu_title = $accueil->page_menu_title;
        if ($page_menu_title == '') {
            $page_menu_title = $accueil->page_title;
        }
        $on = in_array($accueil->page_id, (array) $GLOBALS['page_rail']) && !is_array($_GET['rewrite_ids']);
?>
    <ul>
      <li><a <?= $accueil->get_link() ?> class="<?= $on ? 'on' : '' ?>"><?= $page_menu_title ?></a></li>
<?      self::SousMenuCategorie(null);

        //-------Listage des pages du dossier Menu Header

        $list_page = \Nos\Model_Page::query()
                ->where(array('page_parent_id', DOSSIER_MENU_HEADER))
                ->where(array('page_published', 1))
                ->where(array('page_menu', 1))
                ->get();
        foreach ($list_page as $i => $page1) {
        $page_menu_title = $page1->page_menu_title;
        if ($page_menu_title == '') {
            $page_menu_title = $page1->page_title;
        }
?>
                <li><a <?= $page1->get_link() ?>><?= $page_menu_title ?></a></li>
<?      }
?>
    </ul>
<?
        }

    static function SousMenuCategorie($parent_id = null) {
        $categories = Model_Category::query()
                ->where(array('blgc_parent_id', '=', $parent_id))
                ->get();
        $nb_categorie = count($categories);
        $compteur = 1;
        foreach ($categories as $categorie) {

            $nbss = Model_Category::query()
                ->where(array('blgc_parent_id', '=', $categorie->blgc_id))->get();
            $nbss = count($nbss);

?>
      <li><a href="<?= self::get_url_model($categorie, array('urlPath' => static::$blog_url)) ?>"><?= $categorie->blgc_title ?></a>
<?          if ($nbss) { ?>
        <ul>
<?              self::SousMenuCategorie($categorie->blgc_id); ?>
        </ul>
<?          } ?>
      </li>
<?
            $compteur++;
        }
    }



    static function newLiens() {
?>
<ul class="sf-menu" style="margin:0;">
  <!-- list-style-image pour IE 7 -->
  <?php
  $page_newsletters = \Nos\Model_Page::find(PAGE_INSCRIPTION_NEWSLETTER);
  ?>
  <li style="list-style-type:none;list-style-image: none;"><a href="<?= $page_newsletters->page_virtual_url ?>"><img src="static/images/abonner_actualites.png" border="0" alt="s'abonner aux actualités"  title="s'abonner aux actualités" /></a></li>
  <li style="list-style-type:none;list-style-image: none;"><a href="<?= static::$blog_url ?>?todo=rss" ><img src="static/images/abonner_rss.png" border="0" alt="s'abonner au flux RSS" title="s'abonner au flux RSS" /></a></li>
  <script src="http://widgets.twimg.com/j/2/widget.js"></script>
  <script>
  new TWTR.Widget({
    version: 2,
    type: 'profile',
    rpp: 4,
    interval: 6000,
    width: 204,
    height: 300,
    theme: {
      shell: {
        background: '#ebebeb',
        color: '#333333'
      },
      tweets: {
        background: '#ffffff',
        color: '#000000',
        links: '#474d4d'
      }
    },
    features: {
      scrollbar: false,
      loop: false,
      live: false,
      hashtags: true,
      timestamp: true,
      avatars: false,
      behavior: 'all'
    }
  }).render().setUser('NoviusInfo').start();
  </script>
</ul>
<?
    }

    protected static function url_stats($item, $url = null) {
        if (is_null($url)) {
            $url = \Nos::main_controller()->enhancerUrlPath;
        }
        return $url.'stats/'.urlencode($item->blog_id).'.html';
    }

	static function get_url_model($item, $params = array()) {
		$model = get_class($item);
		$url = isset($params['urlPath']) ? $params['urlPath'] : \Nos\Nos::main_controller()->enhancerUrlPath;
		$page = isset($params['page']) ? $params['page'] : 1;

		switch ($model) {
			case 'Nos\Blog\Model_Blog' :
				return $url.urlencode($item->blog_virtual_name).'.html';
				break;

			case 'Nos\Blog\Model_Category' :
				return $url.'category/'.urlencode($item->blgc_title).($page > 1 ? '/'.$page : '').'.html';
				break;

			case 'Nos\Blog\Model_Tag' :
				return $url.'tag/'.urlencode($item->tag_label).($page > 1 ? '/'.$page : '').'.html';
				break;

			case 'Nos\Model_User' :
				return $url.'author/'.urlencode($item->fullname()).($page > 1 ? '/'.$page : '').'.html';
				break;
		}
	}

}
