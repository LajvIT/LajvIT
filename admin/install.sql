-- --------------------------------------------------------
--
-- Structure for table Event
--

CREATE TABLE IF NOT EXISTS #__lit_event (
 id int(11) NOT NULL auto_increment,
 shortname text NOT NULL,
 name text NOT NULL,
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
 notes text,
 payment int DEFAULT 0,
 timeofpayment datetime,
 confirmed boolean DEFAULT FALSE,
 timeofconfirmation datetime,
 PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Eventpersonroleregistration
--

CREATE TABLE IF NOT EXISTS #__lit_eventpersonroleregistration (
 id int(11) NOT NULL auto_increment,
 personid int NOT NULL,
 eventid int NOT NULL,
 roleid int NOT NULL,
 registrationid int NOT NULL,
 PRIMARY KEY  (personid, eventid),
 CONSTRAINT eventpersonroleregistration_unique UNIQUE (id),
 CONSTRAINT eventpersonroleregistration_personconstr FOREIGN KEY (personid)
 REFERENCES #__lit_person (id) ON DELETE CASCADE,
 CONSTRAINT eventpersonroleregistration_eventconstr FOREIGN KEY (eventid)
 REFERENCES #__lit_event (id) ON DELETE CASCADE,
 CONSTRAINT eventpersonroleregistration_roleconstr FOREIGN KEY (roleid)
 REFERENCES #__lit_role (id) ON DELETE CASCADE,
 CONSTRAINT eventpersonroleregistration_registrationconstr FOREIGN KEY
(registrationid)
 REFERENCES #__lit_registration (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table Characoncept
--

CREATE TABLE IF NOT EXISTS #__lit_characoncept (
 id int(11) NOT NULL auto_increment,
 name text NOT NULL,
 link text,
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
 privat text,

 statusid int NOT NULL,
 PRIMARY KEY  (id),
 CONSTRAINT chara_conceptconstr FOREIGN KEY (conceptid)
 REFERENCES #__lit_characoncept (id) ON DELETE CASCADE,
 CONSTRAINT chara_statusconstr FOREIGN KEY (statusid)
 REFERENCES #__lit_charastatus (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table charainfo
--

CREATE TABLE IF NOT EXISTS #__lit_charainfo (
 id int(11) NOT NULL auto_increment,
 infolevelid int NOT NULL,
 info text NOT NULL,
 PRIMARY KEY (id),
 CONSTRAINT charainfo_infolevelconstr FOREIGN KEY (infolevelid)
 REFERENCES #__lit_infolevel (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

-- --------------------------------------------------------
--
-- Structure for table characharainfo
--

CREATE TABLE IF NOT EXISTS #__lit_characharainfo (
 id int(11) NOT NULL auto_increment,
 charaid int NOT NULL,
 charainfoid int NOT NULL,
 CONSTRAINT  characharainfo_unique UNIQUE (id),
 PRIMARY KEY  (charaid),
 CONSTRAINT characharainfo_characonstr FOREIGN KEY (charaid)
 REFERENCES #__lit_chara (id) ON DELETE CASCADE,
 CONSTRAINT characharainfo_charainfoconstr FOREIGN KEY (charainfoid)
 REFERENCES #__lit_charainfo (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

