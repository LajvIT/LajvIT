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
		
		$cultures = $model->getCharacterCultures();
		$this->assignRef('cultures', $cultures);
		
		$concepts = $model->getCharacterConcepts();
		$this->assignRef('concepts', $concepts);
		
		$charid = JRequest::getInt('cid', -1);
		if ($charid >= 0) {
			$this->assignRef('characterid', $charid);
			
			$character = $model->getCharacterExtended($charid);
			
			if (!is_null($character->bornyear)) {
				$character->age = $events[$eventid]->ingameyear - $character->bornyear;
			}
			
			$this->assignRef('character', $character);
		}
		
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
