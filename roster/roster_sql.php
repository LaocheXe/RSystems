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

CREATE TABLE IF NOT EXISTS `loa_sys` (
  `loa_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `sr_id` int(10) NOT NULL,
  `rank_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `submit_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `effective_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `expected_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `explanation` text,
  `auth_id` int(10) NOT NULL,
  `auth_status` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `return_status` int(3) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`loa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ranks_sys` (
  `rank_id` int(10) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(250) NOT NULL default '',
  `rank_shortname` varchar(25) NOT NULL,
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
  `post_order` int(10) unsigned NOT NULL default '0',
  `post_parent` int(10) unsigned NOT NULL default '0',
  `post_sub` int(10) unsigned NOT NULL default '0',
  `ros_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY(`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `service_records_sys` (
  `sr_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `clone_number` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `arma_id` varchar(255) DEFAULT NULL,
  `ts_guid` varchar(255) DEFAULT NULL,
  `battleeye_guid` varchar(255) DEFAULT NULL,
  `recruiter_id` int(10) NOT NULL,
  `application_id` int(10) NOT NULL,
  `date_join` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `qual_id` text,
  `awards_id` text,
  `rank_id` int(10) NOT NULL,
  `awol_status` int(10) NOT NULL,
  `discharge_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `post_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tis_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tig_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `player_portrate` varchar(255) NULL DEFAULT NULL,
  PRIMARY KEY(`sr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `sr_pending_sys` (
  `srp_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `clone_number` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `arma_id` varchar(255) DEFAULT NULL,
  `recruiter_id` int(10) NOT NULL,
  `application_id` int(10) NOT NULL,
  `c_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY(`srp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `sr_discharged_sys` (
  `srd_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `clone_number` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `arma_id` varchar(255) DEFAULT NULL,
  `ts_guid` varchar(255) DEFAULT NULL,
  `battleeye_guid` varchar(255) DEFAULT NULL,
  `recruiter_id` int(10) NOT NULL,
  `application_id` int(10) NOT NULL,
  `date_join` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `qual_id` text,
  `awards_id` text,
  `rank_id` int(10) NOT NULL,
  `awol_status` int(10) NOT NULL,
  `discharge_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `post_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tis_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tig_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tod_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `dreason` text,
  `player_portrate` varchar(255) NULL DEFAULT NULL,
  PRIMARY KEY(`srd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `qualifications_sys` (
  `qual_id` int(10) NOT NULL AUTO_INCREMENT,
  `qual_name` varchar(200) NOT NULL,
  `qual_description` text NOT NULL,
  `qual_image` varchar(255) NOT NULL,
  PRIMARY KEY (`qual_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `qualified_sys` (
  `qualified_id` int(10) NOT NULL AUTO_INCREMENT,
  `qual_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `qualified_date` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`qualified_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;