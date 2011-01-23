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
	var $illnes = null;
	var $allergies = null;
	var $medicine = null;
	var $info = null;
	var $created = null;

	function __construct(&$db) {
		parent::__construct('#__lit_person', 'id', $db);
		
		$this->created = date('Y-m-d H:i:s');
	}
}
