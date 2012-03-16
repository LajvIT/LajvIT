<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Class for plot table.
 */
class TableLIT_Plot extends LITTable {
  var $id = 0;
  var $heading = '';
  var $description = '';
  var $statusId = NULL;
  var $creatorPersonId = NULL;
  var $created = NULL;
  var $updated = NULL;
  var $lockedByPersonId = NULL;
  var $lockedAt = NULL;
  var $eventId = NULL;

  function __construct(&$db) {
    parent::__construct('#__lit_plot', 'id', $db);

    $this->created = date('Y-m-d H:i:s');
  }

  function check() {
    if (!LITTable::check()) {
      return FALSE;
    }

    if (is_null($this->creatorPersonId)) {
      return FALSE;
    }

    if (is_null($this->statusId)) {
      return FALSE;
    }
    if (is_null($this->eventId)) {
      return FALSE;
    }

    return TRUE;
  }
}
