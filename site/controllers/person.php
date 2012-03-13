<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller for persons.
 */
class LajvITControllerPerson extends LajvITController {
  function edit() {
    JRequest::setVar('view', 'person');
    JRequest::setVar('layout', 'edit');
    //    JRequest::setVar('hidemainmenu', 1);

    parent::display();
  }

  function save() {
    $errlink = 'index.php?option=com_lajvit&controller=person&task=edit';
    $errlink .= '&Itemid='.JRequest::getInt('Itemid', 0);

      $model = &$this->getModel();

      $person = &$model->getPerson();

    $data = JRequest::get('post');
    // Bind the form fields to the record
    if (!$person->bind($data)) {
      echo '<h1>bind</h1>'.$person->getDBO()->getErrorMsg();
      //$this->setRedirect($errlink, 'Database bind error: ' . $person->getDBO()->getErrorMsg());
      return;
    }

    // Store the record to the database
    if (!$person->store()) {
      echo '<h1>store</h1>'.$person->getDBO()->getErrorMsg();
      //$this->setRedirect($errlink, 'Database store error: ' . $person->getDBO()->getErrorMsg());
      return;
    }

    if (!$person->check()) {
      $this->setRedirect($errlink);
      return;
    }

    $oklink = 'index.php?option=com_lajvit&view=event';
    $oklink .= '&Itemid='.JRequest::getInt('Itemid', 0);

    $this->setRedirect($oklink);
  }

}
