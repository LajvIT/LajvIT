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

class LajvITViewRegistrations extends JView {
	function display($tpl = null) {
		$model = &$this->getModel();

		$eventid = JRequest::getInt('eid', -1);
		$this->assignRef('eventid', $eventid);

		$role = $model->getRoleForEvent($eventid);
		$this->assignRef('role', $role);

		if ($role->registration_list || $role->character_list) {
			$factions = $model->getCharacterFactions();
			foreach ($factions as $faction) {
				$faction->characters = $model->getCharactersForFaction($eventid, $faction->id);
			}
		} else {
			$factions = array();
		}
		$this->assignRef('factions', $factions);

		$event = $model->getEvent($eventid);
		$this->assignRef('event', $event);

		$status = $model->getCharacterStatus();
		$this->assignRef('status', $status);

		$confirmations = $model->getConfirmations();
		$this->assignRef('confirmations', $confirmations);

		$characterlist = '';
		foreach ($factions as $faction) {
			foreach ($faction->characters as $char) {
				$characterlist.= ','.$char->id;
			}
		}
		if (strlen($characterlist) > 0) {
			$characterlist = substr($characterlist, 1);
		}
		$this->assignRef('characterlist', $characterlist);

		$this->assignRef('itemid', JRequest::getInt('Itemid', 0));

		parent::display($tpl);
	}
}
