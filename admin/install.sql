-- --------------------------------------------------------
--
-- Structure for table Event
--

CREATE TABLE IF NOT EXISTS #__lit_event (
 id int(11) NOT NULL auto_increment,
 shortname text NOT NULL,
 name text NOT NULL,
 url text NOT NULL,
 firstarrivaldate date,
 preparationdate date,
 startdate date,
 enddate date,
 departuredate date,
 ingameyear int,
 ingamemonth int,
 ingameday int,

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
 shortname text NOT NULL,
 description text,
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
 confirmed boolean DEFAULT FALSE,
 timeofconfirmation datetime,
 PRIMARY KEY  (personid, eventid),
 CONSTRAINT registration_unique UNIQUE (id),
 CONSTRAINT registration_personconstr FOREIGN KEY (personid)
 REFERENCES #__lit_person (id) ON DELETE CASCADE,
 CONSTRAINT registration_eventconstr FOREIGN KEY (eventid)
 REFERENCES #__lit_event (id) ON DELETE CASCADE,
 CONSTRAINT roleregistration_roleconstr FOREIGN KEY (roleid)
 REFERENCES #__lit_role (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Characoncept
--

CREATE TABLE IF NOT EXISTS #__lit_characoncept (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 url text,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Charastatus
--

CREATE TABLE IF NOT EXISTS #__lit_charastatus (
 id int(11) NOT NULL auto_increment,
 description text NOT NULL,
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
 conceptid int,
-- If conceptid is null then use concepttext as concept.
 concepttext text,
-- Private info
 privateinfo text,

 PRIMARY KEY  (id),
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



CREATE OR REPLACE VIEW #__lit_veventsandregistrations AS SELECT 
	#__lit_event.id,
	#__lit_event.name,
	#__lit_event.url,
	#__lit_event.startdate,
	#__lit_event.enddate,
	#__lit_registration.personid,
	#__lit_registration.roleid,
	#__lit_registration.payment,
	#__lit_registration.timeofpayment,
	#__lit_registration.confirmed,
	#__lit_registration.timeofconfirmation
	FROM #__lit_event
	LEFT OUTER JOIN #__lit_registration ON #__lit_event.id = #__lit_registration.eventid
;

CREATE OR REPLACE VIEW #__lit_vcharacters AS SELECT
	#__lit_chara.*,
	#__lit_characoncept.name AS conceptname,
	#__lit_characoncept.url AS concepturl
	FROM #__lit_chara
	LEFT OUTER JOIN #__lit_characoncept ON #__lit_chara.conceptid = #__lit_characoncept.id
;

CREATE OR REPLACE VIEW #__lit_vcharacterregistrations AS SELECT
	#__lit_registrationchara.eventid,
	#__lit_registrationchara.personid,
	#__lit_vcharacters.*,
	#__lit_charastatus.description AS statusdesc
	FROM #__lit_registrationchara
	LEFT OUTER JOIN #__lit_vcharacters ON #__lit_registrationchara.charaid = #__lit_vcharacters.id
	LEFT OUTER JOIN #__lit_charastatus ON #__lit_registrationchara.statusid = #__lit_charastatus.id
;
