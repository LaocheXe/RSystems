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

CREATE TABLE IF NOT EXISTS `cshops_cats_sys` (
  `cshop_id` int(10) NOT NULL AUTO_INCREMENT,
  `userclass_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `cshop_name` varchar(250) NOT NULL default '',
  `cshop_des` text,
  `cshop_parent` int(10) unsigned NOT NULL default '0',
  `cshop_sub` int(10) unsigned NOT NULL default '0',
  `cshop_order` int(10) unsigned NOT NULL default '0',
  `cshop_show` int(10) NOT NULL,
  PRIMARY KEY (`cshop_id`),
  KEY `cshop_parent` (`cshop_parent`),
  KEY `cshop_sub` (`cshop_sub`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `cshops_sys` (
  `cshp_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`cshp_id`)
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

CREATE TABLE IF NOT EXISTS `qualifications_sys` (
  `qual_id` int(10) NOT NULL AUTO_INCREMENT,
  `qual_name` varchar(200) NOT NULL,
  `qual_description` text NOT NULL,
  `qual_image` varchar(255) NOT NULL,
  PRIMARY KEY (`qual_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS history_sys (
  `log_uniqueid` int(11) NOT NULL auto_increment,
  `sys_id` varchar(50) NOT NULL default '',
  `sys_datestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sys_microtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sys_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sys_ip` varchar(45) NOT NULL DEFAULT '',
  `sr_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `clone_id` varchar(255) NOT NULL DEFAULT '',
  `arma_id` varchar(255) NOT NULL DEFAULT '',
  `ts_guid` varchar(255) NOT NULL DEFAULT '',
  `battleeye_guid` varchar(255) NOT NULL DEFAULT '',
  `recruiter_id` int(10) NOT NULL,
  `application_id` int(10) NOT NULL,
  `application_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `application_status` varchar(255) NOT NULL DEFAULT '',
  `application_reason` longtext NOT NULL,
  `application_rep` int(10) NOT NULL,
  `join_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `citation_id` int(10) NOT NULL,
  `awards_id` int(10) NOT NULL,
  `ranks_id` int(10) NOT NULL,
  `rank_change_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `awol_id` int(10) NOT NULL,
  `awol_datestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discharge_id` int(10) NOT NULL,
  `discharge_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discharge_rep` int(10) NOT NULL,
  `transfer_id` int(10) NOT NULL,
  `transfer_submit_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `transfer_complete_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `transfer_rep` int(10) NOT NULL,
  `transfer_from` varchar(255) NOT NULL DEFAULT '',
  `transfer_to` varchar(255) NOT NULL DEFAULT '',
  `transfer_status` varchar(255) NOT NULL DEFAULT '',
  `promotion_id` int(10) NOT NULL,
  `promotion_from` int(10) NOT NULL,
  `promotion_to` int(10) NOT NULL,
  `promotion_status` varchar(255) NOT NULL DEFAULT '',
  `promotion_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `prmotion_rep_y` int(10) NOT NULL,
  `promotion_rep_p` int(10) NOT NULL,
  `promotion_reason_y` longtext NOT NULL,
  `promotion_reason_p` longtext NOT NULL,
  `qualification_id` int(10) NOT NULL,
  `qualification_reason` longtext NOT NULL,
  `qualification_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `qualification_rep` int(10) NOT NULL,
  `trainings_id` int(10) NOT NULL,
  `trainings_attended` varchar(255) NOT NULL DEFAULT '',
  `tranings_attended_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `trainings_pass` varchar(255) NOT NULL DEFAULT '',
  `trainings_pass_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `trainings_rep` int(10) NOT NULL,
  `cshops_id` int(10) NOT NULL,
  `cshops_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `post_id` int(10) NOT NULL,
  `post_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tis_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tig_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `demotion_id` int(10) NOT NULL,
  `demotion_from` int(10) NOT NULL,
  `demotion_to` int(10) NOT NULL,
  `demotion_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `demotion_reason_y` longtext NOT NULL,
  `demotion_status` varchar(255) NOT NULL DEFAULT '',
  `demotion_rep_y` int(10) NOT NULL,
  `demotion_rep_p` int(10) NOT NULL,
  `demotion_reason_p` longtext NOT NULL,
  `demotion_process_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (log_uniqueid),
  UNIQUE KEY sys_id (sys_id)
) ENGINE=MyISAM AUTO_INCREMENT=1;