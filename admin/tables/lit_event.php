<?php

defined('_JEXEC') or die();

require_once('littable.php');

class TableLIT_Event extends LITTable {
	var $id = 0;
	var $shortname = '';
	var $name = '';
	var $url = '';
	var $firstarrivaldate = null;
	var $preparationdate = null;
	var $startdate = null;
	var $enddate = null;
	var $departuredate = null;
	var $ingameyear = null;
	var $ingamemonth = null;
	var $ingameday = null;
	var $description = null;

	function __construct(&$db) {
		parent::__construct('#__lit_event', 'id', $db);
	}
}
