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
 
class LajvITViewEvent extends JView {
    function display($tpl = null) {
    	$model = &$this->getModel();
		
		$events = $model->getEventsForPerson();
		
		foreach ($events as $event) {
			if (is_null($event->personid)) {
				$event->registered = false;
			} else {
				$event->registered = true;
				$event->characters = $model->getCharactersForEvent($event->id, $event->personid);
			}
		}
		
        $this->assignRef('events', $events);
 
        parent::display($tpl);
    }
}
