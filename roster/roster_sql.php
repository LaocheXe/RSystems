<?php exit;?>

CREATE TABLE IF NOT EXISTS `roster_sys` (
  `ros_id` int(10) NOT NULL AUTO_INCREMENT,
  `userclass_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `ros_name` varchar(250) NOT NULL default '',
  `ros_parent` int(10) unsigned NOT NULL default '0',
  `ros_sub` int(10) unsigned NOT NULL default '0',
  `ros_order` int(10) unsigned NOT NULL default '0',
  `ros_show` int(10) NOT NULL,
  PRIMARY KEY (`ros_id`),
  KEY `ros_parent` (`ros_parent`),
  KEY `ros_sub` (`ros_sub`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ranks_sys` (
  `rank_id` int(10) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(250) NOT NULL default '',
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
  `post_name` varchar(250) NOT NULL default '',
  `post_description` text,
  `post_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY(`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `service_records_sys` (
  `sr_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `clone_number` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `arma_id` varchar(255) DEFAULT NULL,
  `ts_guid` varchar(255) DEFAULT NULL,
  `battleeye_guid` varchar(255) DEFAULT NULL,
  `recruiter_id` int(10) NOT NULL,
  `application_date` int(10) NOT NULL,
  `application_status` int(10) NOT NULL,
  `application_rep` int(10) NOT NULL,
  `application_reason` text,
  `date_join` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `citations` text,
  `awards_id` text,
  `rank_id` int(10) NOT NULL,
  `past_ranks` text,
  `awol_status` int(10) NOT NULL,
  `discharge_grade` text,
  `discharge_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discharge_rep` int(11) NOT NULL,
  `transfer_from` text,
  `transfer_date_s` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `transfer_to` text,
  `transfer_rep` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `transfer_status` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `transfer_date_a` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `trainings_attended` text,
  `trainings_pass` text,
  `past_cshops_id` text,
  `cshops_id` text,
  `past_post_id` text,
  `post_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tis_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tig_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `player_portrate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY(`sr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `awards_sys` (
  `award_id` int(10) NOT NULL AUTO_INCREMENT,
  `award_name` varchar(200) NOT NULL,
  `award_description` text NOT NULL,
  `award_image` varchar(255) NOT NULL,
  PRIMARY KEY (`award_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `qualifications_exesystem` (
  `qual_id` int(10) NOT NULL AUTO_INCREMENT,
  `qual_name` varchar(200) NOT NULL,
  `qual_description` text NOT NULL,
  `qual_image` varchar(255) NOT NULL,
  PRIMARY KEY (`qual_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;