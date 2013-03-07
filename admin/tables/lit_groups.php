<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_Groups extends LITTable {
  static $tableName = '#__lit_groups';
  var $id = 0;
  var $asset_id = 0;
  var $name = '';
  var $groupLeaderPersonId = NULL;
  var $description = NULL;
  var $maxParticipants = 0;
  var $expectedParticipants = 0;
  var $url = '';
  var $status = 'created';
  var $adminInformation = NULL;
  var $eventId = NULL;
  var $visible = 0;
  var $factionId = NULL;

  function __construct(&$db) {
    parent::__construct(TableLIT_Groups::$tableName, 'id', $db);
  }

  function check() {
    if (is_null($this->eventId) || $this->eventId == 0) {
      return FALSE;
    }
  }

  /**
   * Overridden bind function
   *
   * @param       array           named array
   * @return      null|string     null if operation was satisfactory, otherwise returns an error
   * @see JTable:bind
   * @since 1.5
   */
  public function bind($array, $ignore = '') {
    // Bind the rules.
    if (isset($array->rules) && is_array($array->rules)) {
      $rules = new JAccessRules($array->rules);
      $this->setRules($rules);
    }

    return parent::bind($array, $ignore);
  }

  /**
   * Method to compute the default name of the asset.
   * The default name is in the form `table_name.id`
   * where id is the value of the primary key of the table.
   *
   * @return      string
   * @since       2.5
   */
  protected function _getAssetName() {
    $k = $this->_tbl_key;
    return 'com_lajvit.group.'.(int) $this->id;
  }

  /**
   * Method to return the title to use for the asset table.
   *
   * @return      string
   * @since       2.5
   */
  protected function _getAssetTitle() {
    return $this->name;
  }

  /**
   * Method to get the asset-parent-id of the item
   *
   * @return      int
   */
  protected function _getAssetParentId() {
    // We will retrieve the parent-asset from the Asset-table
    $assetParent = JTable::getInstance('Asset');
    // Default: if no asset-parent can be found we take the global asset
    $assetParentId = $assetParent->getRootId();

    // Find the parent-asset
    if (($this->eventId) && !empty($this->eventId)) {
      $assetParent->loadByName('com_lajvit.event.' . (int) $this->eventId);
    } else {
      // The item has the component as asset-parent
      $assetParent->loadByName('com_lajvit');
    }

    // Return the found asset-parent-id
    if ($assetParent->id) {
      $assetParentId = $assetParent->id;
    }
    return $assetParentId;
  }
}

