-- --------------------------------------------------------
--
-- Structure for table Event
--

CREATE TABLE IF NOT EXISTS #__lit_event (
 id int(11) NOT NULL auto_increment,
 `asset_id` INT(10) NOT NULL DEFAULT '0',
 shortname text NOT NULL,
 name text NOT NULL,
 url text NOT NULL,
 firstarrivaldate date,
 preparationdate date,
 startdate date NOT NULL,
 enddate date NOT NULL,
 departuredate date,
 ingameyear int NOT NULL,
 ingamemonth int,
 ingameday int,
 status ENUM('created', 'open', 'closed', 'hidden'),
 description text,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000;

-- --------------------------------------------------------
--
-- Structure for table Eventspecifics
--

CREATE TABLE IF NOT EXISTS #__lit_eventspecifics (
 id int(11) NOT NULL auto_increment,
 eventid int(11) NOT NULL,
-- Regarding tells if it is regarding the person or character
 regarding char(1) NOT NULL,
 fieldname text NOT NULL,
 PRIMARY KEY (id),
 CONSTRAINT eventspecifics_eventconstr FOREIGN KEY (eventid)
 REFERENCES #__lit_event (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000;

-- --------------------------------------------------------
--
-- Structure for table person
--

CREATE TABLE IF NOT EXISTS #__lit_person (
 id int(11) NOT NULL,
 givenname text NOT NULL,
 surname text NOT NULL,
 pnumber text NOT NULL,
 sex CHAR(1) NOT NULL,
 phone1 text NOT NULL,
 phone2 text,
 street text NOT NULL,
 zip text NOT NULL,
 town text NOT NULL,
 email text NOT NULL,
 publicemail text,
 icq text,
 msn text,
 skype text,
 facebook text,
 illness text,
 allergies text,
 medicine text,
 info text,
 created datetime,
 PRIMARY KEY  (id)
-- Since the joomla user table isn't InnoDB this doesn't work.
-- id should however be the same as in the joomla user table
-- CONSTRAINT person_idconstr FOREIGN KEY (id)
-- REFERENCES #__users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Structure for table Role
-- Role is in what role a person is connected to an event.
--

CREATE TABLE IF NOT EXISTS #__lit_role (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 description text,
 registration_list boolean NOT NULL DEFAULT FALSE,
 registration_setstatus boolean NOT NULL DEFAULT FALSE,
 registration_setrole boolean NOT NULL DEFAULT FALSE,
 character_list boolean NOT NULL DEFAULT FALSE,
 character_list_hidden boolean NOT NULL DEFAULT FALSE,
 character_setstatus boolean NOT NULL DEFAULT FALSE,
 character_delete boolean NOT NULL DEFAULT FALSE,
 character_view_lvl1 boolean NOT NULL DEFAULT FALSE,
 character_view_lvl2 boolean NOT NULL DEFAULT FALSE,
 character_view_lvl3 boolean NOT NULL DEFAULT FALSE,
 character_view_private boolean NOT NULL DEFAULT FALSE,
 person_viewcontactinfo boolean NOT NULL DEFAULT FALSE,
 person_viewmedical boolean NOT NULL DEFAULT FALSE,
 event_create boolean NOT NULL DEFAULT FALSE,
 event_edit boolean NOT NULL DEFAULT FALSE,
 event_delete boolean NOT NULL DEFAULT FALSE,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;



-- --------------------------------------------------------
--
-- Structure for table Registration
--

CREATE TABLE IF NOT EXISTS #__lit_confirmation (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;


-- --------------------------------------------------------
--
-- Structure for table Registration
--

CREATE TABLE IF NOT EXISTS #__lit_registration (
 id int(11) NOT NULL auto_increment,
 personid int NOT NULL,
 eventid int NOT NULL,
 roleid int NOT NULL,
 notes text,
 payment int DEFAULT 0,
 timeofpayment datetime,
 confirmationid int NOT NULL,
 timeofconfirmation datetime,
 PRIMARY KEY  (personid, eventid),
 CONSTRAINT registration_unique UNIQUE (id),
 CONSTRAINT registration_personconstr FOREIGN KEY (personid)
 REFERENCES #__lit_person (id) ON DELETE CASCADE,
 CONSTRAINT registration_eventconstr FOREIGN KEY (eventid)
 REFERENCES #__lit_event (id) ON DELETE CASCADE,
 CONSTRAINT roleregistration_roleconstr FOREIGN KEY (roleid)
 REFERENCES #__lit_role (id) ON DELETE CASCADE,
 CONSTRAINT confirmationregistration_confitmationconstr FOREIGN KEY (confirmationid)
 REFERENCES #__lit_confirmation (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Charafaction
--

CREATE TABLE IF NOT EXISTS #__lit_charafaction (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 url text,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Characulture
--

CREATE TABLE IF NOT EXISTS #__lit_characulture (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 url text,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Characoncept
--

CREATE TABLE IF NOT EXISTS #__lit_characoncept (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 cultureid int NOT NULL,
 url text,
 PRIMARY KEY  (id),
 CONSTRAINT characoncept_cultureconstr FOREIGN KEY (cultureid)
 REFERENCES #__lit_characulture (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;


-- --------------------------------------------------------
--
-- Structure for table Registrationcharaconceptrole
--

CREATE TABLE IF NOT EXISTS #__lit_registrationcharaconceptrole (
 id int(11) NOT NULL auto_increment,
 personid int NOT NULL,
 eventid int NOT NULL,
 cultureid int NOT NULL,
 conceptid int NOT NULL,
 roleid int NOT NULL,
 PRIMARY KEY  (personid, eventid, cultureid, conceptid, roleid),
 CONSTRAINT registrationcharaconceptrole_unique UNIQUE (id),
 CONSTRAINT registrationcharaconceptrole_personconstr FOREIGN KEY (personid)
 REFERENCES #__lit_registration (personid) ON DELETE CASCADE,
 CONSTRAINT registrationcharaconceptrole_eventconstr FOREIGN KEY (eventid)
 REFERENCES #__lit_registration (eventid) ON DELETE CASCADE,
 CONSTRAINT registrationcharaconceptrole_cultureconstr FOREIGN KEY (cultureid)
 REFERENCES #__lit_characoncept (cultureid) ON DELETE CASCADE,
 CONSTRAINT registrationcharaconceptrole_conceptconstr FOREIGN KEY (conceptid)
 REFERENCES #__lit_characoncept (id) ON DELETE CASCADE,
 CONSTRAINT registrationcharaconceptrole_roleconstr FOREIGN KEY (roleid)
 REFERENCES #__lit_role (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;



-- --------------------------------------------------------
--
-- Structure for table Registrationfactionrole
--

CREATE TABLE IF NOT EXISTS #__lit_registrationfactionrole (
 id int(11) NOT NULL auto_increment,
 personid int NOT NULL,
 eventid int NOT NULL,
 factionid int NOT NULL,
 roleid int NOT NULL,
 PRIMARY KEY  (personid, eventid, factionid, roleid),
 CONSTRAINT registrationfactionrole_unique UNIQUE (id),
 CONSTRAINT registrationfactionrole_personconstr FOREIGN KEY (personid)
 REFERENCES #__lit_registration (personid) ON DELETE CASCADE,
 CONSTRAINT registrationfactionrole_eventconstr FOREIGN KEY (eventid)
 REFERENCES #__lit_registration (eventid) ON DELETE CASCADE,
 CONSTRAINT registrationfactionrole_factionconstr FOREIGN KEY (factionid)
 REFERENCES #__lit_charafaction (id) ON DELETE CASCADE,
 CONSTRAINT registrationfactionrole_roleconstr FOREIGN KEY (roleid)
 REFERENCES #__lit_role (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;



-- --------------------------------------------------------
--
-- Structure for table Charastatus
--

CREATE TABLE IF NOT EXISTS #__lit_charastatus (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 hidden boolean NOT NULL DEFAULT TRUE,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table infolevel
--

CREATE TABLE IF NOT EXISTS #__lit_infolevel (
 id int(11) NOT NULL auto_increment,
 description text NOT NULL,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Chara
--

CREATE TABLE IF NOT EXISTS #__lit_chara (
 id int(11) NOT NULL auto_increment,
 created datetime NOT NULL,
 updated datetime,
 main boolean,
-- Basic info
 knownas text NOT NULL,
 fullname text NOT NULL,
 bornyear int,
 bornmonth int,
 bornday int,
 factionid int,
 cultureid int,
 conceptid int,
-- If conceptid is null then use concepttext as concept.
 concepttext text,
-- Private info
 privateinfo text,
 image text,
 description1 text,
 description2 text,
 description3 text,
 `infoforgroupleader` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

 PRIMARY KEY  (id),
 CONSTRAINT chara_factionconstr FOREIGN KEY (factionid)
 REFERENCES #__lit_charafaction (id) ON DELETE CASCADE,
 CONSTRAINT chara_cultureconstr FOREIGN KEY (cultureid)
 REFERENCES #__lit_characoncept (cultureid) ON DELETE CASCADE,
 CONSTRAINT chara_conceptconstr FOREIGN KEY (conceptid)
 REFERENCES #__lit_characoncept (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table registrationchara
--

CREATE TABLE IF NOT EXISTS #__lit_registrationchara (
 id int(11) NOT NULL auto_increment,
 personid int NOT NULL,
 eventid int NOT NULL,
 charaid int NOT NULL,
 statusid int NOT NULL,
 groupleader text,
 PRIMARY KEY  (personid, eventid, charaid),
 CONSTRAINT registrationchara_unique UNIQUE (id),
 CONSTRAINT registrationchara_registrationconstr FOREIGN KEY (personid, eventid)
 REFERENCES #__lit_registration (personid, eventid) ON DELETE CASCADE,
 CONSTRAINT registrationchara_characonstr FOREIGN KEY (charaid)
 REFERENCES #__lit_chara (id) ON DELETE CASCADE,
 CONSTRAINT registrationchara_statusconstr FOREIGN KEY (statusid)
 REFERENCES #__lit_charastatus (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table charainfo
--

CREATE TABLE IF NOT EXISTS #__lit_charainfo (
 id int(11) NOT NULL auto_increment,
 charaid int NOT NULL,
 infolevelid int NOT NULL,
 info text NOT NULL,
 PRIMARY KEY  (charaid, infolevelid),
 CONSTRAINT  charainfo_unique UNIQUE (id),
 CONSTRAINT charainfo_characonstr FOREIGN KEY (charaid)
 REFERENCES #__lit_chara (id) ON DELETE CASCADE,
 CONSTRAINT charainfo_infolevelconstr FOREIGN KEY (infolevelid)
 REFERENCES #__lit_infolevel (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plotstatus
--

CREATE TABLE IF NOT EXISTS #__lit_plotstatus (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 useravailable tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plot
--

CREATE TABLE IF NOT EXISTS #__lit_plot (
 id int(11) NOT NULL auto_increment,
 heading text NOT NULL,
 description text NOT NULL,
 statusid int NOT NULL,
 eventid int NOT NULL,
 creatorpersonid int,
 created datetime NOT NULL,
 updated datetime,
 lockedbypersonid int,
 lockedat datetime,
 PRIMARY KEY (id),
 CONSTRAINT plot_creator FOREIGN KEY (creatorpersonid)
 REFERENCES #__lit_person (id) ON DELETE SET NULL,
 CONSTRAINT plot_event FOREIGN KEY (eventid)
 REFERENCES #__lit_event (id) ON DELETE CASCADE,
 CONSTRAINT plot_lockedby FOREIGN KEY (lockedbypersonid)
 REFERENCES #__lit_person (id) ON DELETE SET NULL,
 CONSTRAINT plot_status FOREIGN KEY (statusid)
 REFERENCES #__lit_plotstatus (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plotobject
--

CREATE TABLE IF NOT EXISTS #__lit_plotobject (
 id int(11) NOT NULL auto_increment,
 plotid int NOT NULL,
 heading text NOT NULL,
 description text NOT NULL,
 PRIMARY KEY (id),
 CONSTRAINT plotobject_plot FOREIGN KEY (plotid)
 REFERENCES #__lit_plot (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plotobjectrelchara
--

CREATE TABLE IF NOT EXISTS #__lit_plotobjectrelchara (
 plotobjectid int NOT NULL,
 charaid int,
 PRIMARY KEY (plotobjectid, charaid),
 CONSTRAINT plotobjrelchara_plotobject FOREIGN KEY (plotobjectid)
 REFERENCES #__lit_plotobject (id) ON DELETE CASCADE,
 CONSTRAINT plotobjrelchara_chara FOREIGN KEY (charaid)
 REFERENCES #__lit_chara (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plotobjectrelconcept
--

CREATE TABLE IF NOT EXISTS #__lit_plotobjectrelconcept (
 plotobjectid int NOT NULL,
 conceptid int,
 PRIMARY KEY (plotobjectid, conceptid),
 CONSTRAINT plotobjrelconcept_plotobject FOREIGN KEY (plotobjectid)
 REFERENCES #__lit_plotobject (id) ON DELETE CASCADE,
 CONSTRAINT plotobjrelconcept_concept FOREIGN KEY (conceptid)
 REFERENCES #__lit_characoncept (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plotobjectrelculture
--

CREATE TABLE IF NOT EXISTS #__lit_plotobjectrelculture (
 plotobjectid int NOT NULL,
 cultureid int,
 PRIMARY KEY (plotobjectid, cultureid),
 CONSTRAINT plotobjrelculture_plotobject FOREIGN KEY (plotobjectid)
 REFERENCES #__lit_plotobject (id) ON DELETE CASCADE,
 CONSTRAINT plotobjrelculture_culture FOREIGN KEY (cultureid)
 REFERENCES #__lit_characulture (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table plotobjectrelfaction
--

CREATE TABLE IF NOT EXISTS #__lit_plotobjectrelfaction (
 plotobjectid int NOT NULL,
 factionid int,
 PRIMARY KEY (plotobjectid, factionid),
 CONSTRAINT plotobjrelfaction_plotobject FOREIGN KEY (plotobjectid)
 REFERENCES #__lit_plotobject (id) ON DELETE CASCADE,
 CONSTRAINT plotobjrelfaction_faction FOREIGN KEY (factionid)
 REFERENCES #__lit_charafaction (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;


-- --------------------------------------------------------
--
-- Structure for table defaultvalues
--

CREATE TABLE IF NOT EXISTS #__lit_defaultvalues (
  statusid int,
  roleid int,
  factionroleid int,
  confirmationid int,
  CONSTRAINT defaultvalues_statusconstr FOREIGN KEY (statusid)
  REFERENCES #__lit_charastatus (id) ON DELETE SET NULL,
  CONSTRAINT defaultvalues_roleconstr FOREIGN KEY (roleid)
  REFERENCES #__lit_role (id) ON DELETE SET NULL,
  CONSTRAINT defaultvalues_factionroleconstr FOREIGN KEY (factionroleid)
  REFERENCES #__lit_role (id) ON DELETE SET NULL,
  CONSTRAINT defaultvalues_confirmationconstr FOREIGN KEY (confirmationid)
  REFERENCES #__lit_confirmation (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table defaultvalues
--

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
 `factionId` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `groupleader` (`groupLeaderPersonId`),
 KEY `event` (`eventId`),
 INDEX (`factionId`),
 CONSTRAINT `faction` FOREIGN KEY (`factionId`)
  REFERENCES #__lit_charafaction (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS #__lit_group_members (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `groupId` int(10) unsigned NOT NULL,
 `characterId` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `person` (`characterId`),
 KEY `group` (`groupId`),
 UNIQUE `character_group` ( `groupId` , `characterId` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE OR REPLACE VIEW #__lit_vperson AS SELECT
  #__lit_person.*,
  #__users.username
  FROM #__lit_person
  LEFT OUTER JOIN #__users ON #__lit_person.id = #__users.id
;


CREATE OR REPLACE VIEW #__lit_veventsandregistrations AS SELECT
  #__lit_event.*,
  #__lit_vperson.id AS personid,
  #__lit_vperson.username,
  #__lit_registration.roleid,
  #__lit_registration.payment,
  #__lit_registration.timeofpayment,
  #__lit_registration.confirmationid,
  #__lit_registration.timeofconfirmation,
  #__lit_confirmation.name AS confirmationname
  FROM #__lit_event
  INNER JOIN #__lit_vperson
  LEFT OUTER JOIN #__lit_registration ON #__lit_event.id = #__lit_registration.eventid AND
  #__lit_vperson.id = #__lit_registration.personid
  LEFT OUTER JOIN #__lit_confirmation ON #__lit_registration.confirmationid = #__lit_confirmation.id
;

CREATE OR REPLACE VIEW #__lit_veventroles AS SELECT
  #__lit_registration.eventid,
  #__lit_registration.personid,
  #__lit_event.name AS eventname,
  #__lit_role.*
  FROM #__lit_registration
  LEFT OUTER JOIN #__lit_role ON #__lit_registration.roleid = #__lit_role.id
  LEFT OUTER JOIN #__lit_event ON #__lit_registration.eventid = #__lit_event.id
;

CREATE OR REPLACE VIEW #__lit_vconceptroles AS SELECT
  #__lit_registrationcharaconceptrole.eventid,
  #__lit_registrationcharaconceptrole.personid,
  #__lit_registrationcharaconceptrole.cultureid,
  #__lit_registrationcharaconceptrole.conceptid,
  #__lit_characulture.name AS culturename,
  #__lit_characoncept.name AS conceptname,
  #__lit_role.*
  FROM #__lit_registrationcharaconceptrole
  LEFT OUTER JOIN #__lit_role ON #__lit_registrationcharaconceptrole.roleid = #__lit_role.id
  LEFT OUTER JOIN #__lit_characulture ON #__lit_registrationcharaconceptrole.cultureid = #__lit_characulture.id
  LEFT OUTER JOIN #__lit_characoncept ON #__lit_registrationcharaconceptrole.conceptid = #__lit_characoncept.id
;

CREATE OR REPLACE VIEW #__lit_vcharaconceptroles AS SELECT
  #__lit_chara.id AS charaid,
  #__lit_registrationcharaconceptrole.eventid,
  #__lit_registrationcharaconceptrole.personid,
  #__lit_registrationcharaconceptrole.cultureid,
  #__lit_registrationcharaconceptrole.conceptid,
  #__lit_role.*
  FROM #__lit_chara
  LEFT OUTER JOIN #__lit_registrationcharaconceptrole ON #__lit_chara.cultureid = #__lit_registrationcharaconceptrole.cultureid AND #__lit_chara.conceptid = #__lit_registrationcharaconceptrole.conceptid
  LEFT OUTER JOIN #__lit_role ON #__lit_registrationcharaconceptrole.roleid = #__lit_role.id
;

CREATE OR REPLACE VIEW #__lit_vfactionroles AS SELECT
  #__lit_registrationfactionrole.eventid,
  #__lit_registrationfactionrole.personid,
  #__lit_registrationfactionrole.factionid,
  #__lit_charafaction.name AS factionname,
  #__lit_role.*
  FROM #__lit_registrationfactionrole
  LEFT OUTER JOIN #__lit_role ON #__lit_registrationfactionrole.roleid = #__lit_role.id
  LEFT OUTER JOIN #__lit_charafaction ON #__lit_registrationfactionrole.factionid = #__lit_charafaction.id
;

CREATE OR REPLACE VIEW #__lit_vcharafactionroles AS SELECT
  #__lit_chara.id AS charaid,
  #__lit_registrationfactionrole.eventid,
  #__lit_registrationfactionrole.personid,
  #__lit_registrationfactionrole.factionid,
  #__lit_charafaction.name AS factionname,
  #__lit_role.*
  FROM #__lit_chara
  LEFT OUTER JOIN #__lit_registrationfactionrole ON #__lit_chara.factionid = #__lit_registrationfactionrole.factionid
  LEFT OUTER JOIN #__lit_role ON #__lit_registrationfactionrole.roleid = #__lit_role.id
  LEFT OUTER JOIN #__lit_charafaction ON #__lit_registrationfactionrole.factionid = #__lit_charafaction.id
;

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

CREATE OR REPLACE VIEW #__lit_vcharacterregistrations AS SELECT
  #__lit_registrationchara.eventid,
  #__lit_registrationchara.personid,
  #__lit_vcharacters.*,
  #__lit_registrationchara.statusid,
  #__lit_charastatus.name AS statusname,
  #__lit_charastatus.hidden AS hidden,
  #__lit_registration.roleid,
  #__lit_role.name AS rolename,
  #__lit_registration.payment,
  #__lit_registration.confirmationid,
  #__lit_confirmation.name AS confirmationname,
  #__lit_registration.timeofconfirmation,
  CONCAT(#__lit_vperson.givenname, ' ', #__lit_vperson.surname) AS personname,
  #__lit_vperson.pnumber,
  #__lit_vperson.username
  FROM #__lit_registrationchara
  LEFT OUTER JOIN #__lit_vcharacters ON #__lit_registrationchara.charaid = #__lit_vcharacters.id
  LEFT OUTER JOIN #__lit_charastatus ON #__lit_registrationchara.statusid = #__lit_charastatus.id
  LEFT OUTER JOIN #__lit_registration ON #__lit_registrationchara.eventid = #__lit_registration.eventid AND #__lit_registrationchara.personid = #__lit_registration.personid
  LEFT OUTER JOIN #__lit_vperson ON #__lit_registrationchara.personid = #__lit_vperson.id
  LEFT OUTER JOIN #__lit_confirmation ON #__lit_registration.confirmationid = #__lit_confirmation.id
  LEFT OUTER JOIN #__lit_role ON #__lit_registration.roleid = #__lit_role.id
;
