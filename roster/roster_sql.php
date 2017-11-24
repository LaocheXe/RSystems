<?php exit;?>

CREATE TABLE IF NOT EXISTS `roster_sys` (
  `ros_id` int(10) NOT NULL AUTO_INCREMENT,
  `ros_parent` int(10) NOT NULL,
  `ros_sub` int(10) unsigned NOT NULL default '0',
  `ros_order` int(10) NOT NULL,
  `ros_show`	int(10) NOT NULL,
  `user_class_id'	int(10) NOT NULL,
  PRIMARY KEY (`ros_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ranks_sys` (
  `rank_id` int(10) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(250) NOT NULL,
  `rank_shortname` varchar(5) NOT NULL,
  `rank_description` text,
  `rank_image` varchar(255) DEFAULT NULL,
  `rank_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `rank_order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rank_id`),
  KEY `rank_parent` (`rank_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `postition_sys` (
  `post_id` int(10) NOT NULL AUTO_INCREMENT,
  `post_name` text NOT NULL,
  `post_description` text NOT NULL,
  `post_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY(`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `service_records_sys` (
  `sr_id` int(10) NOT NULL auto_increment,
  `user_id int(11) NOT NULL,
  `date` int(10) NOT NULL,
  `entry` text,
  `type` text,
  `awards_id` text,
  `rank_id` int(10) NOT NULL,
  `citation` text,
  `discharge_grade` text,
  `position` text,
  `rocat_id` int(10) DEFAULT NULL,
  `display` text,
  PRIMARY KEY(`sr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;