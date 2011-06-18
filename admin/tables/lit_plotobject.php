<?php

defined('_JEXEC') or die();

require_once('littable.php');

class TableLIT_PlotObject extends LITTable {
	var $id = 0;
	var $heading = '';
	var $description = '';
	var $plotid = NULL;

	function __construct(&$db) {
		parent::__construct('#__lit_plotobject', 'id', $db);
	}

	function check() {
		if (!LITTable::check()) {
			return false;
		}

		if (is_null($this->$plotid) || $this->$plotid <= 0) {
			return false;
		}
		return true;
	}
}
