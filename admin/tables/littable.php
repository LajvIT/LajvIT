<?php

defined('_JEXEC') or die();

/**
 * Class for extending JTable to LIT.
 */
class LITTable extends JTable {
  var $_forcenew = FALSE;

  /**
   * Inserts a new row if id is zero or updates an existing row in the database table
   *
   * Can be overloaded/supplemented by the child class
   *
   * @access public
   * @param boolean If FALSE, null object variables are not updated
   * @return null|stringnull if successful otherwise returns and error message
   */
  function store($updateNulls = FALSE) {
    $k = $this->_tbl_key;
    $currentAssetId = 0;
    if (!empty($this->asset_id)) {
      $currentAssetId = $this->asset_id;
    }

    // The asset id field is managed privately by this class.
    if ($this->_trackAssets) {
      unset($this->asset_id);
    }

    if (!$this->_forcenew && $this->$k) {
      $ret = $this->_db->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
    } else {
      $ret = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
    }

    if (!$ret) {
      $this->setError(get_class( $this ).'::store failed - '.$this->_db->getErrorMsg());
      return FALSE;
    }

    // If the table is not set to track assets return true.
    if (!$this->_trackAssets) {
      return TRUE;
    }

    if ($this->_locked) {
      $this->_unlock();
    }

    $parentId = $this->_getAssetParentId();
    $name = $this->_getAssetName();
    $title = $this->_getAssetTitle();

    $asset = JTable::getInstance('Asset', 'JTable', array('dbo' => $this->getDbo()));
    $asset->loadByName($name);

    // Re-inject the asset id.
    $this->asset_id = $asset->id;

    // Check for an error.
    if ($error = $asset->getError()) {
      $this->setError($error);
      return FALSE;
    }

    // Specify how a new or moved node asset is inserted into the tree.
    if (empty($this->asset_id) || $asset->parent_id != $parentId) {
      $asset->setLocation($parentId, 'last-child');
    }

    // Prepare the asset to be stored.
    $asset->parent_id = $parentId;
    $asset->name = $name;
    $asset->title = $title;

    if ($this->_rules instanceof JAccessRules) {
      $asset->rules = (string) $this->_rules;
    }

    if (!$asset->check() || !$asset->store($updateNulls)) {
      $this->setError($asset->getError());
      return FALSE;
    }

    // Create an asset_id or heal one that is corrupted.
    if (empty($this->asset_id) || ($currentAssetId != $this->asset_id && !empty($this->asset_id))) {
      // Update the asset_id field in this table.
      $this->asset_id = (int) $asset->id;

      $query = $this->_db->getQuery(TRUE);
      $query->update($this->_db->quoteName($this->_tbl));
      $query->set('asset_id = ' . (int) $this->asset_id);
      $query->where($this->_db->quoteName($k) . ' = ' . (int) $this->$k);
      $this->_db->setQuery($query);

      if (!$this->_db->execute()) {
        $e = new JException(JText::sprintf('JLIB_DATABASE_ERROR_STORE_FAILED_UPDATE_ASSET_ID', $this->_db->getErrorMsg()));
        $this->setError($e);
        return FALSE;
      }
    }

    return TRUE;
  }
}
