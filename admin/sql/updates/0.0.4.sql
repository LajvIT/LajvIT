CREATE TABLE IF NOT EXISTS #__lit_group_leaders (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `groupId` int(10) unsigned NOT NULL,
 `personId` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `person` (`personId`),
 KEY `group` (`groupId`),
 UNIQUE `person_group` ( `groupId` , `personId` ),
 CONSTRAINT `groupLeaderGroup` FOREIGN KEY (`groupId`) REFERENCES `#__lit_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `groupLeaderPerson` FOREIGN KEY (`personId`) REFERENCES `#__lit_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO #__lit_group_leaders (groupId, personId) SELECT id, groupLeaderPersonId FROM #__lit_groups;