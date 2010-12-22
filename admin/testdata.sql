--
-- Data in table event
--

INSERT INTO #__lit_event (id, shortname, name, startdate, enddate, description) VALUES
(100, 'KH5', 'Krigshjärta 5', '2011-7-10', '2011-7-15',  'Det senaste
lajvet i Krigshjärtaserien. Kommer hållas under 2011.');

--
-- Data in table Eventspecifics
--

INSERT INTO #__lit_eventspecifics (id, eventid, regarding, fieldname) VALUES
(100, 100, 'P', 'Detta vill och kan jag hjälpa till med i kampanjen:
(Beskriv din tidigare erfarenhet och vad du kan tänkas hjälpa till
med. Intressanta områden kan vara exempelvis sjukvård, tross, smink,
pyro, stunts, slp:er, illustrationer, texter, korrekturläsning,
intriger, deltagarkontakter, musik, funktionär, arrangör,
dokumenation, rekvisita, byggnationer, IT)'),
(102, 100, 'P', 'Den här typen av upplevelser uppskattar jag på lajv:
(Beskriv vad du gillar med lajv. Kanske konflikter, Strid, Misär, Mys,
Sång, Lägerliv, Politik...)'),
(103, 100, 'P', 'Det här är upplevelser jag helst vill undvika:
(Beskriv vad du vill slippa råka ut för på lajv)'),
(104, 100, 'P', 'Den här scenen skulle jag vilja uppleva nån gång i
Krigshjärtakrönikan: (Beskriv minst en scen som du gärna vill uppleva
i kampanjen)'),
(105, 100, 'P', 'Innan ett lajv aktiverar jag mig gärna genom att: (Är
du intresserad av att åka på workshops, deltagarträffar, bygghelger,
hur mycket läser du forum, i vilken grad söker du kontakt med andra
deltagare, i vilken grad vill du ha arrangörskontakter)');
(106, 100, 'C', 'Beskriv hur din karaktär har påverkats av krigets
intåg i Jorgala.');

--
-- Data in table person
--
-- DOESN'T WORK YET! XXX

INSERT INTO #__lit_person (id, name, email) VALUES
(0, 'root', root@localhost')
(101, 'AdminEmil', 'emil@djupfeldt.se'),
(102, 'AdminTexas', 'texas.se@gmail.com');

--
-- Data in table role
--

INSERT INTO #__lit_role (id, shortname, name, description) VALUES
(1, 'Arrangör', 'Huvudsakligen ansvariga för lajvet.'),
(2, 'Deltagare', NULL),
(3, 'Redaktör', 'Skriver.'),
(4, 'Skribent', 'Hjälper till med att skriva texter.'),
(5, 'Korrekturläsare', 'Rättar fel.');

--
-- Data in table registration
--

INSERT INTO #__lit_registration (id, notes, payment, timeofpayment,
confirmed, timeofconfirmation) VALUES
(101, NULL, 0, NULL, FALSE, NULL),
(102, NULL, 0, NULL, FALSE, NULL);

--
-- Data in table Eventpersonroleregistration
--

INSERT INTO #__lit_eventpersonroleregistration (id, personid, eventid,
roleid, registrationid) VALUES
(101, 101, 101, 1, 101),
(102, 102, 101, 2, 102);

--
-- Data in table Characoncept
--

INSERT INTO #__lit_characoncept (id, name, link) VALUES
(0, 'Eget koncept', NULL),
(101, 'Gillesknekt', 'http://krigshjarta.se/?page=42');

--
-- Data in table Charastatus
--

INSERT INTO #__lit_charastatus (id, description) VALUES
(1, 'Skapad'),
(2, 'Avslagen'),
(3, 'Godkänd');

--
-- Data in table Infolevel
--

INSERT INTO #__lit_infolevel (id, description) VALUES
(1, 'Generell'),
(2, 'Bekant'),
(3, 'Närstående');

--
-- Data in table Chara
--

INSERT INTO #__lit_event (id, created, pimary, knownas, fullname, bornyear,
bornmonth, bornday, conceptid, concepttext, private, status) VALUES
(101, NOW(), true, 'Äpplet', 'Valdemar Apfel', 200, 3, 1, 101, NULL,
'Minnesanteckning...', 1);

--
-- Data in table charainfo
--

INSERT INTO #__lit_charainfo (id, infolevelid, info) VALUES
(101, 1, 'Spelar och super som de flesta knektar.'),
(102, 2, 'Har stora spelskulder.'),
(103, 3, 'Har ärvt en enorm summa pengar.');

--
-- Data in table characharainfo
--

INSERT INTO #__lit_characharainfo (id, charaid, charinfoid) VALUES
(101, 101, 101),
(102, 101, 102);
