<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_Event extends LITTable {
  static $tableName = '#__lit_event';
  var $id = 0;
  var $asset_id = 0;
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
  var $status = 'created';

  function __construct(&$db) {
    parent::__construct(self::$tableName, 'id', $db);
  }

  public function bind($array, $ignore = '') {
    // Bind the rules.
    if (isset($array['rules']) && is_array($array['rules'])) {
      $rules = new JAccessRules($array['rules']);
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
    return 'com_lajvit.event.'.(int) $this->$k;
  }

  /**
   * Method to return the title to use for the asset table.
   *
   * @return      string
   * @since       2.5
   */
  protected function _getAssetTitle() {
    return $this->shortname;
  }

  /**
   * Method to get the asset-parent-id of the item
   *
   * @return      int
   */
  protected function _getAssetParentId() {
    $assetParent = JTable::getInstance('Asset');
    $assetParentId = $assetParent->getRootId();

    $assetParent->loadByName('com_lajvit');

    if ($assetParent->id) {
      $assetParentId = $assetParent->id;
    }
    return $assetParentId;
  }
}
