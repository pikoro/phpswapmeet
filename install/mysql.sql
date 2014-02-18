-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2009 at 03:26 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `okinawaswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `fs_available`
--

CREATE TABLE IF NOT EXISTS `fs_available` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `game_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_categories`
--

CREATE TABLE IF NOT EXISTS `fs_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Categories' AUTO_INCREMENT=433 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_feedback`
--

CREATE TABLE IF NOT EXISTS `fs_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `to_user` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `value` enum('-1','0','1') NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Feedback ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_folders`
--

CREATE TABLE IF NOT EXISTS `fs_folders` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `folder_name` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_games`
--

CREATE TABLE IF NOT EXISTS `fs_games` (
  `id` int(11) NOT NULL auto_increment,
  `platform` int(11) NOT NULL,
  `title` text NOT NULL,
  `publisher` int(11) NOT NULL,
  `esrb_rating` int(11) default NULL,
  `cero_rating` int(11) default NULL,
  `region` int(11) default NULL,
  `image` text,
  `description` text,
  `genre` int(11) default NULL,
  `link` text,
  `rating` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_items`
--

CREATE TABLE IF NOT EXISTS `fs_items` (
  `id` int(11) NOT NULL auto_increment,
  `custid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `list_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Individual Items' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_log`
--

CREATE TABLE IF NOT EXISTS `fs_log` (
  `id` int(11) NOT NULL auto_increment,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `entry` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_messages`
--

CREATE TABLE IF NOT EXISTS `fs_messages` (
  `id` int(11) NOT NULL auto_increment,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL default '0',
  `folder` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_msg_archive`
--

CREATE TABLE IF NOT EXISTS `fs_msg_archive` (
  `id` int(11) NOT NULL auto_increment,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL default '0',
  `folder` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_news`
--

CREATE TABLE IF NOT EXISTS `fs_news` (
  `id` int(11) NOT NULL auto_increment,
  `post_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  `article` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Holds News Posts' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_owned`
--

CREATE TABLE IF NOT EXISTS `fs_owned` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `game_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_platform`
--

CREATE TABLE IF NOT EXISTS `fs_platform` (
  `id` int(11) NOT NULL auto_increment,
  `platform` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_publisher`
--

CREATE TABLE IF NOT EXISTS `fs_publisher` (
  `id` int(11) NOT NULL auto_increment,
  `publisher` varchar(50) default NULL,
  `active` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_swap_log`
--

CREATE TABLE IF NOT EXISTS `fs_swap_log` (
  `id` int(11) NOT NULL auto_increment,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `trade_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_users`
--

CREATE TABLE IF NOT EXISTS `fs_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email1` varchar(50) NOT NULL,
  `email2` varchar(50) default NULL,
  `dob` date NOT NULL COMMENT 'Date of Birth',
  `access_level` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `confirm_key` varchar(20) default NULL,
  `registered` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_wanted`
--

CREATE TABLE IF NOT EXISTS `fs_wanted` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

