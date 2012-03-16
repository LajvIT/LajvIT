<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

/**
 * View for My pages.
 */
class LajvITViewMyPages extends JView {
  function display($tpl = NULL) {
    $model = &$this->getModel();
    $person = &$model->getPerson();
    parent::display($tpl);
  }
}
