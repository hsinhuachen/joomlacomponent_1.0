CREATE TABLE IF NOT EXISTS `#__onion_slide` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` TEXT NOT NULL ,
`message` TEXT NOT NULL ,
`link` TEXT NOT NULL ,
`photo` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__onion_projects` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` TEXT NOT NULL ,
`message` TEXT NOT NULL ,
`photo` VARCHAR(255)  NOT NULL ,
`category` int(11),
`datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`latest` tinyint(2) NOT NULL DEFAULT '0',
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL DEFAULT '1',
`account` bigint(20) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__onion_category` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` TEXT NOT NULL ,
`parents` INT(11)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__onion_feature` (
`id` int(11) unsigned NOT NULL auto_increment,
`key` text NOT NULL,
`value` text NOT NULL,
`parents` int(11) NOT NULL,
`ordering` int(11) NOT NULL,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;



