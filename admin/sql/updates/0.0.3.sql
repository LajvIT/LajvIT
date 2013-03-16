CREATE TABLE IF NOT EXISTS #__lit_groups (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
 `name` varchar(55) DEFAULT 'unnamed',
 `groupLeaderPersonId` int(11) DEFAULT NULL,
 `descriptionPublic` text,
 `descriptionPrivate` text,
 `maxParticipants` int(10) unsigned NOT NULL DEFAULT '0',
 `expectedParticipants` int(11) NOT NULL DEFAULT '0',
 `url` varchar(255) DEFAULT '',
 `status` enum('created','approved','rejected','open','closed','hidden') NOT NULL DEFAULT 'created',
 `adminInformation` text,
 `eventId` int(11) DEFAULT NULL,
 `visible` tinyint(1) NOT NULL DEFAULT '0',
 `factionId` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `groupleader` (`groupLeaderPersonId`),
 KEY `event` (`eventId`),
 INDEX (`factionId`),
 CONSTRAINT `faction` FOREIGN KEY (`factionId`)
  REFERENCES #__lit_charafaction (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS #__lit_group_members (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `groupId` int(10) unsigned NOT NULL,
 `characterId` int(11) NOT NULL DEFAULT '0',
 `groupLeaderInfo` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
 `groupMemberInfo` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `person` (`characterId`),
 KEY `group` (`groupId`),
 UNIQUE `character_group` ( `groupId` , `characterId` ),
 CONSTRAINT `group` FOREIGN KEY (`groupId`) REFERENCES `#__lit_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `character` FOREIGN KEY (`characterId`) REFERENCES `#__lit_chara` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `#__lit_event` ADD COLUMN `asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `#__lit_chara` ADD `infoforgroupleader` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `description3`;
CREATE OR REPLACE VIEW #__lit_vcharacters AS SELECT
  #__lit_chara.*,
  #__lit_charafaction.name AS factionname,
  #__lit_charafaction.url AS factionurl,
  #__lit_characulture.name AS culturename,
  #__lit_characulture.url AS cultureurl,
  #__lit_characoncept.name AS conceptname,
  #__lit_characoncept.url AS concepturl
  FROM #__lit_chara
  LEFT OUTER JOIN #__lit_charafaction ON #__lit_chara.factionid = #__lit_charafaction.id
  LEFT OUTER JOIN #__lit_characulture ON #__lit_chara.cultureid = #__lit_characulture.id
  LEFT OUTER JOIN #__lit_characoncept ON #__lit_chara.conceptid = #__lit_characoncept.id
;