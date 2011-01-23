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
    	
    	$events = $model->getEventsForPerson();
        $this->assignRef('events', $events);
        
		$eventid = JRequest::getInt('eid', -1);
		$this->assignRef('eventid', $eventid);
		// TODO: Check eid in case of action
		
		$cultures = $model->getCharacterCultures();
		$this->assignRef('cultures', $cultures);
		
		$concepts = $model->getCharacterConcepts();
		$this->assignRef('concepts', $concepts);
		
    	
        parent::display($tpl);
    }
}
