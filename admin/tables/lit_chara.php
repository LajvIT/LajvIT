<?php

defined('_JEXEC') or die();

require_once('littable.php');

class TableLIT_Chara extends LITTable {
	var $id = 0;
	var $created = '';
	var $updated = null;
	var $main = false;
	var $knownas = '';
	var $fullname = '';
	var $bornyear = null;
	var $bornmonth = null;
	var $bornday = null;
	var $conceptid = null;
	var $concepttext = null;
	var $privateinfo = null;

	function __construct(&$db) {
		parent::__construct('#__lit_chara', 'id', $db);
		
		$this->created = date('Y-m-d H:i:s');
	}
}
