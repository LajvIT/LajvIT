<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Class for person table.
 */
class TableLIT_Person extends LITTable {
  var $id = 0;
  var $givenname = '';
  var $surname = '';
  var $pnumber = '';
  var $phone1 = '';
  var $phone2 = NULL;
  var $street = '';
  var $zip = '';
  var $town = '';
  var $email = '';
  var $publicemail = NULL;
  var $sex = '?';
  var $icq = NULL;
  var $msn = NULL;
  var $skype = NULL;
  var $facebook = NULL;
  var $illness = NULL;
  var $allergies = NULL;
  var $medicine = NULL;
  var $info = NULL;
  var $created = NULL;

  function __construct(&$db) {
    parent::__construct('#__lit_person', 'id', $db);

    $this->created = date('Y-m-d H:i:s');
  }

  function check() {
    if (!LITTable::check()) {
      return FALSE;
    }

    if (is_NULL($this->givenname) || strlen($this->givenname) == 0) {
      return FALSE;
    }

    if (is_NULL($this->surname) || strlen($this->surname) == 0) {
      return FALSE;
    }

    if (is_NULL($this->pnumber) || strlen($this->pnumber) == 0) {
      return FALSE;
    }

    if (is_NULL($this->phone1) || strlen($this->phone1) == 0) {
      return FALSE;
    }

    if (is_NULL($this->street) || strlen($this->street) == 0) {
      return FALSE;
    }

    if (is_NULL($this->zip) || strlen($this->zip) == 0) {
      return FALSE;
    }

    if (is_NULL($this->town) || strlen($this->town) == 0) {
      return FALSE;
    }

    if (strtoupper($this->sex) != 'F' && strtoupper($this->sex) != 'M') {
      return FALSE;
    }

    return TRUE;
  }
}
