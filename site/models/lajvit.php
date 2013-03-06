<?php
/**
 * Hello Model for Hello World Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_2
 * @license    GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelLajvIT extends JModelLegacy {
  /**
   * Gets the greeting
   * @return string The greeting to be displayed to the user
   */
  function getGreeting() {
    return 'Hello, World!';
  }

  function getDefaultStatusId() {
    $db = &JFactory::getDBO();

    $query = 'SELECT statusid FROM #__lit_defaultvalues LIMIT 1;';
    $db->setQuery($query);

    return $db->loadResult();
  }

  function getDefaultRoleId() {
    $db = &JFactory::getDBO();

    $query = 'SELECT roleid FROM #__lit_defaultvalues LIMIT 1;';
    $db->setQuery($query);

    return $db->loadResult();
  }

  function getDefaultFactionRoleId() {
    $db = &JFactory::getDBO();

    $query = 'SELECT factionroleid FROM #__lit_defaultvalues LIMIT 1;';
    $db->setQuery($query);

    return $db->loadResult();
  }

  function getDefaultConfirmationId() {
    $db = &JFactory::getDBO();

    $query = 'SELECT confirmationid FROM #__lit_defaultvalues LIMIT 1;';
    $db->setQuery($query);

    return $db->loadResult();
  }

  function getCharacterFactions() {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_charafaction;';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharacterCultures() {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_characulture;';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharacterConcepts() {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_characoncept;';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharacterStatus() {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_charastatus;';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getConfirmations() {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_confirmation;';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharacterConcept($conceptId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_characoncept WHERE id = '. $conceptId .';';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharacterCulture($cultureId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_characulture WHERE id = '. $cultureId .';';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharacterFaction($factionId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_charafaction WHERE id = '. $factionId .';';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  /**
   * Method to get a person, or an empty person structure if
   * the person hasn't been created in the LajvIT module yet. Returns
   * FALSE if the user doesn't exist in Joomla.
   * @param int $userid
   * @return boolean|TableLIT_Person
   */
  function getPerson($userid = NULL) {
    $user = JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;

    $row = &JTable::getInstance('lit_person', 'Table');

    if ($row && !$row->load($user->id)) {
      $row->_forcenew = TRUE;
      $row->id = $user->id;
      $names = explode(" ", $user->name);
      $row->givenname = $names[0];
      $row->surname = implode(" ", array_slice($names, 1));
      $row->email = $user->email;

      $row->_nodata = TRUE;
    } else {
      $row->_nodata = FALSE;
    }

    $row->_username = $user->username;

    return $row;
  }

  /**
   * Method to get the person id owning a character registered for an event
   * @param int $characterId
   * @param int $eventId
   * @return Ambigous <int, NULL> The person id or NULL if query fails
   */
  public function getPersonIdOwningCharacterOnEvent($characterId, $eventId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT personid FROM #__lit_registrationchara WHERE charaid = '. $characterId .
             ' AND eventid = ' . $eventId . ';';
    $db->setQuery($query);
    return $db->loadResult();
  }

  function mergeRoles($a, $b) {
    $ret = new stdClass;

    if (is_null($a) || !$a) {
      return $b;
    }

    if (is_null($b) || !$b) {
      return $a;
    }

    $name = $a->name.','.$b->name;

    foreach (get_object_vars($a) as $k => $v) {
      $ret->$k = $v;
    }

    foreach (get_object_vars($b) as $k => $v) {
      if (array_key_exists($k, $ret) && $ret->$k != NULL && $ret->$k != 0) {
        $ret->$k = $ret->$k;
      } else {
        $ret->$k = $v;
      }
    }

    $ret->name = $name;

    return $ret;
  }

  function getRoleForEvent($eventid, $userid = NULL) {
    $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_veventroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).' LIMIT 1;';

    $db->setQuery($query);
    $ret = $db->loadObject();
    return is_null($ret) ? FALSE : $ret;
  }

  function getRoleForConcept($eventid, $cultureid, $conceptid, $userid = NULL) {
    $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vconceptroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).' AND cultureid='.$db->getEscaped($cultureid).' AND conceptid='.$db->getEscaped($conceptid).' LIMIT 1;';

    $db->setQuery($query);

    $ret = $db->loadObject();
    return is_null($ret) ? FALSE : $ret;
  }

  function getRoleForFaction($eventid, $factionId, $userid = NULL) {
    $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vfactionroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).' AND factionid='.$db->getEscaped($factionId).' LIMIT 1;';

    $db->setQuery($query);

    $ret = $db->loadObject();
    return is_null($ret) ? FALSE : $ret;
  }

  function getRoleForChara($eventid, $charaid, $userid = NULL) {
    $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharaconceptroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).' AND charaid='.$db->getEscaped($charaid).' LIMIT 1;';

    $db->setQuery($query);

    $crole = $db->loadObject();

    $query = 'SELECT * FROM #__lit_vcharafactionroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).' AND charaid='.$db->getEscaped($charaid).' LIMIT 1;';

    $db->setQuery($query);

    $frole = $db->loadObject();

    $ret = $this->mergeRoles($crole, $frole);

    return is_null($ret) ? FALSE : $ret;
  }

  function getAllRolesMerged($eventid, $userid = NULL) {
    $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $ret = $this->getRoleForEvent($eventid, $user->id);
    $eventname = $ret->eventname;
    $name = $ret->name;

    $query = 'SELECT * FROM #__lit_vfactionroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).';';

    $db->setQuery($query);

    $froles = $db->loadObjectList();

    foreach ($froles as $role) {
      $ret = $this->mergeRoles($ret, $role);
      $name .= ", ".$role->name." (".$role->factionname.")";
    }

    $query = 'SELECT * FROM #__lit_vconceptroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).';';

    $db->setQuery($query);

    $croles = $db->loadObjectList();

    foreach ($croles as $role) {
      $ret = $this->mergeRoles($ret, $role);
      $name .= ", ".$role->name." (".$role->culturename.": ".$role->conceptname.")";
    }

    $ret->eventname = $eventname;
    $ret->name = $name;

    return $ret;
  }

  function getRegistration($userid, $eventid, $charid) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_registrationchara WHERE personid='.$db->getEscaped($userid).' AND eventid='.$db->getEscaped($eventid).' AND charaid='.$db->getEscaped($charid).' LIMIT 1;';

    $db->setQuery($query);

    $ret = $db->loadObject();
    return is_null($ret) ? FALSE : $ret;
  }

  function getEventsForPerson($person = NULL) {
    $user = &JFactory::getUser($person);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_veventsandregistrations WHERE personid IS NULL OR personid='.$user->id.';';

    $db->setQuery($query);
    return $db->loadObjectList("id");
  }

  function getCharactersForEvent($event, $person = NULL) {
    $user = &JFactory::getUser($person);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($event).';';

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getAllCharactersForEvent($event, $person = NULL) {
    $user = &JFactory::getUser($person);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE eventid='.$db->getEscaped($event).';';

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getAllCharactersForEventInFaction($event, $factionId, $person = NULL) {
    $user = &JFactory::getUser($person);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE eventid=' .
        $db->getEscaped($event).' AND factionid=' . $db->getEscaped($factionId) . ';';

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getCharacterRegistrationForEvent($event, $characterId, $person = NULL) {
    $user = &JFactory::getUser($person);
    if (!$user || $user->guest)
      return FALSE;

    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($event).' AND id = '.$db->getEscaped($characterId).';';
    $db->setQuery($query);
    return $db->loadObject();
  }

  function getCharactersForFaction($event, $faction, $orderBy, $orderDirection, $characterStatus, $confirmation) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE eventid='.$db->getEscaped($event). ' AND factionid='.$db->getEscaped($faction);

    if (is_numeric($characterStatus) ) {
      $query .= " AND statusid = " . $db->getEscaped($characterStatus);
    }
    if (is_numeric($confirmation)) {
      $query .= " AND confirmationid = " . $db->getEscaped($confirmation);
    }

    switch ($orderBy) {
      case 'knownas':
        $query .= " ORDER BY knownas";
        break;
      case 'culture':
        $query .= " ORDER BY culturename";
        break;
      case 'concept':
        $query .= " ORDER BY conceptname";
        break;
      case 'personname':
        $query .= " ORDER BY personname";
        break;
      case 'created':
        $query .= " ORDER BY created";
        break;
      case 'updated':
        $query .= " ORDER BY updated";
        break;
      default:
        break;
    }

    if ( $orderDirection != '' && ($orderDirection == 'DESC' || $orderDirection == 'DESC')) {
      $query .= " " . $orderDirection;
    }

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getCharacterExtended($charid) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_vcharacters WHERE id='.$db->getEscaped($charid).' LIMIT 1;';

    $db->setQuery($query);

    $ret = $db->loadObject();
    return is_null($ret) ? FALSE : $ret;
  }

  function &getCharacter($charid) {
    /*
     $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;
    */

    $row = &JTable::getInstance('lit_chara', 'Table');

    $row->load($charid);

    return $row;
  }

  function getCharactersOnEventForPerson($eventId, $personId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_chara AS chara
    INNER JOIN #__lit_registrationchara ON charaid = chara.id
    WHERE personid = '.$db->getEscaped($personId).' AND eventid = '.$db->getEscaped($eventId).';';

    $db->setQuery($query);

    return $db->loadObjectList();
  }

  function isCharacterOwnedByPerson($characterId, $personId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_chara AS characters
    INNER JOIN #__lit_registrationchara ON charaid = characters.id
    WHERE personid = '.$db->getEscaped($personId).' AND charaid = '.$db->getEscaped($characterId).';';
    $db->setQuery($query);
    if (count($db->loadObjectList()) > 0) {
      return TRUE;
    }
    return FALSE;
  }

  function isCharacterRegisteredOnEvent($characterId, $eventId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_chara AS characters
    INNER JOIN #__lit_registrationchara ON charaid = characters.id
    WHERE eventid = '.$db->getEscaped($eventId).' AND charaid = '.$db->getEscaped($characterId).';';
    $db->setQuery($query);
    if (count($db->loadObjectList()) > 0) {
      return TRUE;
    }
    return FALSE;
  }

  function hasCharacterPastFirstStatusCheck($characterId) {
    $db = &JFactory::getDBO();

    $query = 'SELECT * FROM #__lit_registrationchara
    WHERE charaid = '.$db->getEscaped($characterId).' AND statusid > 100;';
    $db->setQuery($query);
    if (count($db->loadObjectList()) > 0) {
      return TRUE;
    }
    return FALSE;
  }

  function &getEvent($eventid) {
    /*
     $user = &JFactory::getUser($userid);
    if (!$user || $user->guest)
      return FALSE;
    */

    $row = JTable::getInstance('event', 'TableLIT_');
    $row->load($eventid);

    return $row;
  }

  function deleteEvent($eventId) {
    $user = &JFactory::getUser($userid);
    if (!$user || $user->guest || $user->usertype != "Super Administrator") {
      return FALSE;
    }
    $db = &JFactory::getDBO();;
    $query = 'DELETE FROM #__lit_event WHERE id = ' . $db->getEscaped($eventId) . ';';

    $db->setQuery($query);
    if (!$db->query()) {
      return FALSE;
    }
    return TRUE;
  }

  function getFaction ($factionId) {
    $db = &JFactory::getDBO();;
    $query = 'SELECT * FROM  #__lit_charafaction WHERE id = ' . $db->getEscaped($factionId) . ';';
    $db->setQuery($query);
    $ret = $db->loadObject();
    return $ret;
  }

  /**
   *
   * @param int $factionId
   * @return mixed String if faction found, or NULL if not
   */
  function getFactionName ($factionId) {
    $faction = $this->getFaction($factionId);
    if (is_null($faction)) {
      return NULL;
    } else {
      return $faction->name;
    }
  }

  function getPlotHeading($plotId) {
    $plot = $this->getPlot($plotId);
    if (is_null($plot)) {
      return NULL;
    } else {
      return $plot->heading;
    }
  }

  function getPlotDescription($plotId) {
    $plot = $this->getPlot($plotId);
    if (is_null($plot)) {
      return NULL;
    } else {
      return $plot->description;
    }
  }

  function getPlotCreator($plotId) {
    $plot = $this->getPlot($plotId);
    return is_null($plot) ? NULL : $plot->creatorpersonid;
  }

  function getPlotStatus($plotId) {
    $plot = $this->getPlot($plotId);
    if (is_null($plot)) {
      return NULL;
    } else {
      $ret = $this->getPlotStatuses($plot->statusid);
      return $ret[0];
    }
  }

  function getPlotStatuses($statusId = NULL) {
    $db = &JFactory::getDBO();
    $query = 'SELECT * FROM #__lit_plotstatus';
    if ($statusId != NULL) {
      $query .= " WHERE id = ". $db->getEscaped($statusId);
    }
    $query .= ';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlot($plotId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT * FROM #__lit_plot WHERE id='.$db->getEscaped($plotId).' LIMIT 1;';
    $db->setQuery($query);
    $ret = $db->loadObject();
    return $ret;
  }

  function getPlotsForEvent($eventId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT #__lit_plot.*, #__lit_plotstatus.name as statusname FROM #__lit_plot ';
    $query .= 'INNER JOIN #__lit_plotstatus ON statusid = #__lit_plotstatus.id WHERE eventid ='.$db->getEscaped($eventId).';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectsDistributedForEventOnCharacter($eventId, $characterId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT plotobject.* FROM #__lit_plot as plot INNER JOIN  #__lit_plotobject as plotobject ON plot.id = plotid ';
    $query .= 'INNER JOIN #__lit_plotstatus as plotstatus ON statusid = plotstatus.id AND plotstatus.useravailable = 1 ';
    $query .= 'INNER JOIN #__lit_plotobjectrelchara as chararel ON chararel.plotobjectid = plotobject.id AND chararel.charaid = ' . $db->getEscaped($characterId) . " ";
    $query .= 'WHERE plot.eventid = ' . $db->getEscaped($eventId);

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectsDistributedForEventOnCulture($eventId, $cultureId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT plotobject.* FROM #__lit_plot as plot INNER JOIN  #__lit_plotobject as plotobject ON plot.id = plotid ';
    $query .= 'INNER JOIN #__lit_plotstatus as plotstatus ON statusid = plotstatus.id AND plotstatus.useravailable = 1 ';
    $query .= 'INNER JOIN #__lit_plotobjectrelculture as culturerel ON culturerel.plotobjectid = plotobject.id AND culturerel.cultureid = ' . $db->getEscaped($cultureId) . " ";
    $query .= 'WHERE plot.eventid = ' . $db->getEscaped($eventId);

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectsDistributedForEventOnConcept($eventId, $conceptId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT plotobject.* FROM #__lit_plot as plot ' .
        'INNER JOIN  #__lit_plotobject as plotobject ON plot.id = plotid ' .
        'INNER JOIN #__lit_plotstatus as plotstatus ON statusid = plotstatus.id ' .
        'AND plotstatus.useravailable = 1 INNER JOIN #__lit_plotobjectrelconcept as conceptrel ' .
        'ON conceptrel.plotobjectid = plotobject.id AND conceptrel.conceptid = ' .
        $db->getEscaped($conceptId) . ' WHERE plot.eventid = ' . $db->getEscaped($eventId);

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectsDistributedForEventOnFaction($eventId, $factionId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT plotobject.* FROM #__lit_plot as plot ' .
        'INNER JOIN  #__lit_plotobject as plotobject ON plot.id = plotid ' .
        'INNER JOIN #__lit_plotstatus as plotstatus ON statusid = plotstatus.id ' .
        'AND plotstatus.useravailable = 1 INNER JOIN #__lit_plotobjectrelfaction as factionrel ' .
        'ON factionrel.plotobjectid = plotobject.id AND factionrel.factionid = ' .
        $db->getEscaped($factionId) . ' WHERE plot.eventid = ' . $db->getEscaped($eventId);

    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectsForPlot($plotId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT * FROM #__lit_plotobject WHERE plotid ='.$db->getEscaped($plotId).';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObject($plotObjectId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT * FROM #__lit_plotobject WHERE id ='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);
    return $db->loadObject();
  }

  function getPlotObjectCharacterRelations($plotObjectId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT #__lit_chara.id as id, #__lit_chara.fullname AS name
    FROM #__lit_plotobject
    INNER JOIN #__lit_plotobjectrelchara ON #__lit_plotobject.id = plotobjectid
    INNER JOIN #__lit_chara ON #__lit_chara.id = charaid
    WHERE #__lit_plotobject.id ='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectConceptRelations($plotObjectId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT concept.id as id, concept.name AS name, culture.name AS culturename
    FROM #__lit_plotobject
    INNER JOIN #__lit_plotobjectrelconcept ON #__lit_plotobject.id = plotobjectid
    INNER JOIN #__lit_characoncept AS concept ON concept.id = conceptid
    INNER JOIN #__lit_characulture AS culture ON concept.cultureid = culture.id
    WHERE #__lit_plotobject.id ='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectCultureRelations($plotObjectId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT #__lit_characulture.id as id, #__lit_characulture.name AS name
    FROM #__lit_plotobject
    INNER JOIN #__lit_plotobjectrelculture ON #__lit_plotobject.id = plotobjectid
    INNER JOIN #__lit_characulture ON #__lit_characulture.id = cultureid
    WHERE #__lit_plotobject.id ='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function getPlotObjectFactionRelations($plotObjectId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT #__lit_charafaction.id as id, #__lit_charafaction.name AS name
    FROM #__lit_plotobject
    INNER JOIN #__lit_plotobjectrelfaction ON #__lit_plotobject.id = plotobjectid
    INNER JOIN #__lit_charafaction ON #__lit_charafaction.id = factionid
    WHERE #__lit_plotobject.id ='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  function deleteSubPlotCharacterRelation($relId, $plotObjectId) {
    $this->deleteSubPlotRelation($relId, $plotObjectId, 'chara', 'charaid');
  }

  function deleteSubPlotConceptRelation($relId, $plotObjectId) {
    $this->deleteSubPlotRelation($relId, $plotObjectId, 'concept', 'conceptid');
  }

  function deleteSubPlotCultureRelation($relId, $plotObjectId) {
    $this->deleteSubPlotRelation($relId, $plotObjectId, 'culture', 'cultureid');
  }

  function deleteSubPlotFactionRelation($relId, $plotObjectId) {
    $this->deleteSubPlotRelation($relId, $plotObjectId, 'faction', 'factionid');
  }

  private function deleteSubPlotRelation($relId, $plotObjectId, $relation, $columnName) {
    $db = &JFactory::getDBO();
    $query = 'DELETE FROM #__lit_plotobjectrel' . $relation . ' WHERE ' . $columnName . ' ='.
        $db->getEscaped($relId).' AND plotobjectid='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);

    if (!$db->query() ) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
    }
  }

  function addSubPlotRelationToCharacter($plotObjectId, $characterId) {
    $db = &JFactory::getDBO();
    $query = 'INSERT INTO #__lit_plotobjectrelchara SET charaid ='.$db->getEscaped($characterId).
    ', plotobjectid='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);

    if (!$db->query() ) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
      return FALSE;
    }
    return TRUE;
  }

  function addSubPlotRelationToConcept($plotObjectId, $conceptId) {
    $db = &JFactory::getDBO();
    $query = 'INSERT INTO #__lit_plotobjectrelconcept SET conceptid ='.$db->getEscaped($conceptId).
    ', plotobjectid='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);

    if (!$db->query() ) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
      return FALSE;
    }
    return TRUE;
  }

  function addSubPlotRelationToCulture($plotObjectId, $cultureId) {
    $db = &JFactory::getDBO();
    $query = 'INSERT INTO #__lit_plotobjectrelculture SET cultureid ='.$db->getEscaped($cultureId).
    ', plotobjectid='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);

    if (!$db->query() ) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
      return FALSE;
    }
    return TRUE;
  }

  function addSubPlotRelationToFaction($plotObjectId, $factionId) {
    $db = &JFactory::getDBO();
    $query = 'INSERT INTO #__lit_plotobjectrelfaction SET factionid ='.$db->getEscaped($factionId).
    ', plotobjectid='.$db->getEscaped($plotObjectId).';';
    $db->setQuery($query);

    if (!$db->query() ) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
      return FALSE;
    }
    return TRUE;
  }


  function addFactionRole($personid, $eventid, $factionid, $roleid) {
    $db = &JFactory::getDBO();

    $data = new stdClass;
    $data->personid = $personid;
    $data->eventid = $eventid;
    $data->factionid = $factionid;
    $data->roleid = $roleid;

    $db->insertObject('#__lit_registrationfactionrole', $data);
    return $db->getErrorNum() == 0;
  }


  function fixDefaultFactionRoleForChara($personid, $eventid, $charid) {
    if (!$this->getRegistration($personid, $eventid, $charid)) {
      return FALSE;
    }

    $chara = &$this->getCharacter($charid);
    if (!$chara) {
      return FALSE;
    }

    return $this->addFactionRole($personid, $eventid, $chara->factionid,
        $this->getDefaultFactionRoleId());
  }
}
