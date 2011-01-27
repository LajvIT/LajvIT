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
 
class LajvITViewPerson extends JView {
    function display($tpl = null) {
    	$model = &$this->getModel();
    	
    	$person = &$model->getPerson();
    	
		$incomplete = !$person->_nodata && !$person->check();
		$this->assignRef('incomplete_person', $incomplete);
    	
        $this->assignRef('givenname', $person->givenname);
        $this->assignRef('surname', $person->surname);
        $this->assignRef('pnumber', $person->pnumber);
        $this->assignRef('sex', $person->sex);
        $this->assignRef('email', $person->email);
        $this->assignRef('publicemail', $person->publicemail);
        $this->assignRef('phone1', $person->phone1);
        $this->assignRef('phone2', $person->phone2);
        $this->assignRef('street', $person->street);
        $this->assignRef('zip', $person->zip);
        $this->assignRef('town', $person->town);
        $this->assignRef('icq', $person->icq);
        $this->assignRef('msn', $person->msn);
        $this->assignRef('skype', $person->skype);
        $this->assignRef('facebook', $person->facebook);
        $this->assignRef('illness', $person->illness);
        $this->assignRef('allergies', $person->allergies);
        $this->assignRef('medicine', $person->medicine);
        $this->assignRef('info', $person->info);
        
		$this->assignRef('itemid', JRequest::getInt('Itemid', 0));
        
        parent::display($tpl);
    }
}
