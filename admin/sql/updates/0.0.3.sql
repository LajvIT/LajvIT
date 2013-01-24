ALTER TABLE`#__lit_event` ADD COLUMN `asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;

CREATE TABLE IF NOT EXISTS #__lit_groups (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
 `name` varchar(55) DEFAULT 'unnamed',
 `groupLeaderPersonId` int(11) DEFAULT NULL,
 `description` text,
 `maxParticipants` int(10) unsigned NOT NULL DEFAULT '0',
 `expectedParticipants` int(11) NOT NULL DEFAULT '0',
 `url` varchar(255) DEFAULT '',
 `status` enum('created','approved','rejected','open','closed','hidden') NOT NULL DEFAULT 'created',
 `adminInformation` text,
 `eventId` int(11) DEFAULT NULL,
 `visible` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `groupleader` (`groupLeaderPersonId`),
 KEY `event` (`eventId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8