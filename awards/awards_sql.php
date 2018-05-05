<?php exit;?>

CREATE TABLE IF NOT EXISTS `awards_sys` (
  `award_id` int(10) NOT NULL AUTO_INCREMENT,
  `award_name` varchar(200) NOT NULL,
  `award_description` text NOT NULL,
  `award_image` varchar(255) NOT NULL,
  PRIMARY KEY (`award_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `awarded_sys` (
  `awarded_id` int(10) NOT NULL AUTO_INCREMENT,
  `award_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `awarded_date` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`awarded_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `awards_request_sys` (
  `request_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `reason_wanted` text NOT NULL,
  `award_image` varchar(255) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;