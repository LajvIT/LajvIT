<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_Event extends LITTable {
  static $tableName = '#__lit_event';
  var $id = 0;
  var $shortname = '';
  var $name = '';
  var $url = '';
  var $firstarrivaldate = NULL;
  var $preparationdate = NULL;
  var $startdate = NULL;
  var $enddate = NULL;
  var $departuredate = NULL;
  var $ingameyear = NULL;
  var $ingamemonth = NULL;
  var $ingameday = NULL;
  var $description = NULL;

  function __construct(&$db) {
    parent::__construct($this->tableName, 'id', $db);
  }
}
