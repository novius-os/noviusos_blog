--
-- Structure de la table `noviusos_blog_category`
--

CREATE TABLE IF NOT EXISTS `nos_blog_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  `cat_virtual_name` varchar(255) NOT NULL,
  `cat_lang` varchar(5) NOT NULL,
  `cat_lang_common_id` int(11) NOT NULL,
  `cat_lang_single_id` int(11) DEFAULT NULL,
  `cat_parent_id` int(11) DEFAULT NULL,
  `cat_sort` float DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_lang` (`cat_lang`,`cat_lang_common_id`,`cat_lang_single_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `nos_blog_category_post`
--

CREATE TABLE IF NOT EXISTS `nos_blog_category_post` (
  `post_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nos_blog_post`
--

CREATE TABLE IF NOT EXISTS `nos_blog_post` (
  `post_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `post_title` varchar(250) NOT NULL,
  `post_summary` text NOT NULL,
  `post_author_alias` varchar(255) DEFAULT NULL,
  `post_author_id` int(10) unsigned DEFAULT NULL,
  `post_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `post_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_lang` varchar(5) NOT NULL,
  `post_lang_common_id` int(11) NOT NULL,
  `post_lang_single_id` int(11) DEFAULT NULL,
  `post_published` tinyint(1) NOT NULL,
  `post_read` int(10) unsigned NOT NULL,
  `post_virtual_name` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `news_virtual_name` (`post_virtual_name`),
  KEY `news_lang` (`post_lang`,`post_lang_common_id`,`post_lang_single_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Structure de la table `nos_blog_tag`
--

CREATE TABLE IF NOT EXISTS `nos_blog_tag` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_label` varchar(255) NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_label` (`tag_label`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `nos_blog_tag_post`
--

CREATE TABLE IF NOT EXISTS `nos_blog_tag_post` (
  `post_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  KEY `tag_id` (`tag_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;