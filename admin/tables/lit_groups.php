<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_Groups extends LITTable {
  static $tableName = '#__lit_groups';
  var $id = 0;
  var $name = '';
  var $description = NULL;
  var $maxParticipants = 0;
  var $url = '';
  var $status = 'created';
  var $adminInformation = NULL;
  var $eventId = NULL;

  function __construct(&$db) {
    parent::__construct($this->tableName, 'id', $db);
  }
}

