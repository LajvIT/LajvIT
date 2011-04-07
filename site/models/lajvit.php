<?php
/**
 * Hello Model for Hello World Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_2
 * @license    GNU/GPL
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class LajvITModelLajvIT extends JModel {
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getGreeting() {
		return 'Hello, World!';
	}

	function getDefaultStatusId() {
		$db = &JFactory::getDBO();

		$query = 'SELECT MIN(id) FROM #__lit_charastatus WHERE id >= 100;';
		$db->setQuery($query);

		return $db->loadResult();
	}

	function getDefaultRoleId() {
		$db = &JFactory::getDBO();

		$query = 'SELECT MIN(id) FROM #__lit_role WHERE id >= 100;';
		$db->setQuery($query);

		return $db->loadResult();
	}

	function getDefaultConfirmationId() {
		$db = &JFactory::getDBO();

		$query = 'SELECT MIN(id) FROM #__lit_confirmation WHERE id >= 100;';
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

	function &getPerson($userid = null) {
		$user = &JFactory::getUser($userid);
		if (!$user || $user->guest)
		return false;

		$row = &JTable::getInstance('lit_person', 'Table');

		if (!$row->load($user->id)) {
			$row->_forcenew = true;
			$row->id = $user->id;
			$names = explode(" ", $user->name);
			$row->givenname = $names[0];
			$row->surname = implode(" ", array_slice($names, 1));
			$row->email = $user->email;

			$row->_nodata = true;
		} else {
			$row->_nodata = false;
		}

		return $row;
	}

	function getRoleForEvent($eventid, $userid = null) {
		$user = &JFactory::getUser($userid);
		if (!$user || $user->guest)
		return false;

		$db = &JFactory::getDBO();

		$query = 'SELECT * FROM #__lit_veventroles WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($eventid).' LIMIT 1;';

		$db->setQuery($query);

		$ret = $db->loadObject();
		return is_null($ret) ? false : $ret;
	}

	function getRegistration($userid, $eventid, $charid) {
		$db = &JFactory::getDBO();

		$query = 'SELECT * FROM #__lit_registrationchara WHERE personid='.$db->getEscaped($userid).' AND eventid='.$db->getEscaped($eventid).' AND charaid='.$db->getEscaped($charid).' LIMIT 1;';

		$db->setQuery($query);

		$ret = $db->loadObject();
		return is_null($ret) ? false : $ret;
	}

	function getEventsForPerson($person = null) {
		$user = &JFactory::getUser($person);
		if (!$user || $user->guest)
		return false;

		$db = &JFactory::getDBO();

		$query = 'SELECT * FROM #__lit_veventsandregistrations WHERE personid IS NULL OR personid='.$user->id.';';

		$db->setQuery($query);
		return $db->loadObjectList("id");
	}

	function getCharactersForEvent($event, $person = null) {
		$user = &JFactory::getUser($person);
		if (!$user || $user->guest)
		return false;

		$db = &JFactory::getDBO();

		$query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE personid='.$user->id.' AND eventid='.$db->getEscaped($event).';';

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCharactersForFaction($event, $faction) {
		$db = &JFactory::getDBO();

		$query = 'SELECT * FROM #__lit_vcharacterregistrations WHERE eventid='.$db->getEscaped($event). ' AND factionid='.$db->getEscaped($faction);

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCharacterExtended($charid) {
		$db = &JFactory::getDBO();

		$query = 'SELECT * FROM #__lit_vcharacters WHERE id='.$db->getEscaped($charid).' LIMIT 1;';

		$db->setQuery($query);

		$ret = $db->loadObject();
		return is_null($ret) ? false : $ret;
	}

	function &getCharacter($charid) {
		/*
		 $user = &JFactory::getUser($userid);
		 if (!$user || $user->guest)
		 return false;
		 */

		$row = &JTable::getInstance('lit_chara', 'Table');

		$row->load($charid);

		return $row;
	}

	function &getEvent($eventid) {
		/*
		 $user = &JFactory::getUser($userid);
		 if (!$user || $user->guest)
		 return false;
		 */

		$row = &JTable::getInstance('lit_event', 'Table');

		$row->load($eventid);

		return $row;
	}
}
