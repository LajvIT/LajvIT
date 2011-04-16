<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */

class LajvITViewCharacter extends JView {
	function display($tpl = null) {
		$model = &$this->getModel();

		$person = &$model->getPerson();

		$events = $model->getEventsForPerson();
		$this->assignRef('events', $events);

		$eventid = JRequest::getInt('eid', -1);
		$this->assignRef('eventid', $eventid);

		$factions = $model->getCharacterFactions();
		$this->assignRef('factions', $factions);

		$cultures = $model->getCharacterCultures();
		$this->assignRef('cultures', $cultures);

		$concepts = $model->getCharacterConcepts();
		$this->assignRef('concepts', $concepts);

    	$role = $model->getRoleForEvent($eventid);
		
		$charid = JRequest::getInt('cid', -1);
		if ($charid >= 0) {
			$this->assignRef('characterid', $charid);

			$character = $model->getCharacterExtended($charid);

			if (!is_null($character->bornyear)) {
				$character->age = $events[$eventid]->ingameyear - $character->bornyear;
			}

			$this->assignRef('character', $character);
			
			$crole = $model->getRoleForChara($eventid, $charid);
			$role = $model->mergeRoles($role, $crole);
		}
		
		$this->assignRef('role', $role);

		$err = JRequest::getInt('failed', 0);
		$this->assignRef('failed', $err);

		$fullname = JRequest::getString('fullname', '');
		$factionid = JRequest::getInt('factionid', 0);
		$cultureid = JRequest::getInt('cultureid', 0);
		$conceptid = JRequest::getInt('conceptid', 0);

		$this->assignRef('fullname', $fullname);
		$this->assignRef('factionid', $factionid);
		$this->assignRef('cultureid', $cultureid);
		$this->assignRef('conceptid', $conceptid);


		$this->assignRef('itemid', JRequest::getInt('Itemid', 0));

		if ($this->getLayout() == 'edit') {
			$reg = $model->getRegistration($person->id, $eventid, $charid);
			if (!$reg) {
				$this->setLayout('default');
				/*
				 $link = 'index.php?option=com_lajvit&view=character&eid='.$eventid.'&cid='.$charid;
				 $link.= '&Itemid='.JRequest::getInt('Itemid', 0);
				 $this->setRedirect($link);
				 return;
				 */
			}
		}

		parent::display($tpl);
	}
}
