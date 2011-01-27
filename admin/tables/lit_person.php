<?php

defined('_JEXEC') or die();

require_once('littable.php');

class TableLIT_Person extends LITTable {
	var $id = 0;
	var $givenname = '';
	var $surname = '';
	var $pnumber = '';
	var $phone1 = '';
	var $phone2 = null;
	var $street = '';
	var $zip = '';
	var $town = '';
	var $email = '';
	var $publicemail = null;
	var $sex = '?';
	var $icq = null;
	var $msn = null;
	var $skype = null;
	var $facebook = null;
	var $illness = null;
	var $allergies = null;
	var $medicine = null;
	var $info = null;
	var $created = null;

	function __construct(&$db) {
		parent::__construct('#__lit_person', 'id', $db);
		
		$this->created = date('Y-m-d H:i:s');
	}
	
	function check() {
		if (!LITTable::check()) {
			return false;
		}
		
		if (is_null($this->givenname) || strlen($this->givenname) == 0) {
			return false;
		}
		
		if (is_null($this->surname) || strlen($this->surname) == 0) {
			return false;
		}
		
		if (is_null($this->pnumber) || strlen($this->pnumber) == 0) {
			return false;
		}
		
		if (is_null($this->phone1) || strlen($this->phone1) == 0) {
			return false;
		}
		
		if (is_null($this->street) || strlen($this->street) == 0) {
			return false;
		}
		
		if (is_null($this->zip) || strlen($this->zip) == 0) {
			return false;
		}
		
		
		if (is_null($this->town) || strlen($this->town) == 0) {
			return false;
		}
		
		if (strtoupper($this->sex) != 'F' && strtoupper($this->sex) != 'M') {
			return false;
		}
		
		return true;
	}
}
