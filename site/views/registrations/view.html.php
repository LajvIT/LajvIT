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

		$characterStatus = JRequest::getInt('charstatus', null);
		$this->assignRef('characterStatus', $characterStatus);
		$confirmation = $role->registration_list ? JRequest::getInt('confirmation', null) : null;
		$this->assignRef('confirmation', $confirmation);
		$factionid = JRequest::getInt('factionid', null);
		$this->assignRef('factionid', $factionid);

		$queries = array();

		$orderBy = JRequest::getString('orderby', '');
		$sortorder = JRequest::getString('sortorder', 'ASC');
		$this->assignRef('sortOrder', $sortorder);
		$this->assignRef('orderBy', $orderBy);


		$page = JRequest::getInt('page', 0);
		$this->assignRef('page', $page);


		$mergedrole = $role;
		$factions = $model->getCharacterFactions();

		foreach ($factions as $faction) {
			if ($factionid == null || $factionid == $faction->id) {
				$faction->characters = $model->getCharactersForFaction($eventid, $faction->id, $orderBy, $sortorder, $characterStatus, $confirmation);
			} else {
				$faction->characters = array();
			}

			foreach ($faction->characters as $i => $char) {
				$crole = $model->getRoleForChara($eventid, $char->id);
				$mergedrole = $model->mergeRoles($mergedrole, $crole);
				$char->role = $model->mergeRoles($role, $crole);

				if (!$char->role->registration_list &&
					!($char->role->character_list && !$char->hidden) &&
					!$char->role->character_list_hidden) {
					unset($faction->characters[$i]);
				}
			}
		}


		if (JRequest::getInt('fixdb', 0) == 1) {
			$user = &JFactory::getUser($person);
			if ($user && !$user->guest) {
				foreach ($factions as $faction) {
					foreach ($faction->characters as $char) {
						$model->fixDefaultFactionRoleForChara($char->personid, $char->eventid, $char->id);
					}
				}
			}
		}

		$this->assignRef('mergedrole', $mergedrole);
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
