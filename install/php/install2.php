<?php
#error_reporting(0);
if (!isset($_SESSION['reg_user'])) {
     header('Location: index.php?page=install');
}


R::exec("SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(550) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS category (
	`id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
	
	`name` VARCHAR(40) DEFAULT '' NOT NULL COMMENT 'category name',
	
 `created_on`  DATETIME NOT NULL,
 `updated_on`  DATETIME NOT NULL,
 PRIMARY KEY (id),
 UNIQUE KEY (name)
) ENGINE='MyISAM' COMMENT = 'categories' CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO `category` (`id`, `name`, `created_on`, `updated_on`) VALUES ('1', 'top level', NOW(), NOW() );

CREATE TABLE IF NOT EXISTS `divs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(550) NOT NULL,
  `name_encoded` varchar(550) NOT NULL,
  `content` longtext NOT NULL,
  `timestamp` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `category_id` INT UNSIGNED DEFAULT '1' NOT NULL,
  PRIMARY KEY (`id`),
  INDEX index_category_id( category_id )
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

INSERT INTO `divs` (`id`, `name`, `name_encoded`, `content`, `timestamp`, `active`, `category_id`) VALUES
(1, 'Demo Page', '736640b24569a', '&lt;h1&gt;Hello, this is my first CMS page!&lt;/h1&gt;\r\n&lt;p&gt;You can edit ths content and it will change dynamically on your site in real-time. Try it.&lt;/p&gt;\r\n&lt;p&gt;When you''ve added something, paste the &amp;lt;!-(abc123456)--&amp;gt; code into your site, wherever you want this content to appear.&lt;/p&gt;\r\n&lt;p&gt;Enjoy editing your site from this amazingly simple CMS.&lt;/p&gt;', 1433655261, 1, '1');

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(550) NOT NULL,
  `name_encoded` varchar(550) NOT NULL,
  `rights` varchar(550) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


INSERT INTO `menu` (`id`, `title`, `name_encoded`, `rights`) VALUES
(1, 'Pages', 'pages', 'All'),
(2, 'Categories', 'category_list', 'All'),
(3, 'Users', 'users', 'Admin'),
(4, 'My Account', 'account', 'All'),
(5, 'CMS Settings', 'settings', 'Admin');

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(550) NOT NULL,
  `setting` varchar(550) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `settings` (`id`, `name`, `setting`) VALUES
(1, 'logo', 'logo.png');


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(550) NOT NULL,
  `password` varchar(550) NOT NULL,
  `salt` varchar(550) NOT NULL,
  `request_token` varchar(550) DEFAULT NULL,
  `request_time` int(11) NOT NULL,
  `email` varchar(550) NOT NULL,
  `function` varchar(500) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;



");

$salt = hash("sha256", $_SESSION['reg_user']['username'] . $_SESSION['reg_user']['email'] . time());

$div = R::dispense('users');
$div->username = $_SESSION['reg_user']['username'];
$div->password = $_SESSION['reg_user']['password'];
$div->salt = $salt;
$div->email = $_SESSION['reg_user']['email'];
$div->function = "Admin";
$div->timestamp = time();
$div->active = true;
$id = R::store($div);

unset($_SESSION['reg_user']);

$smarty->display('templates/install2.tpl');
?>