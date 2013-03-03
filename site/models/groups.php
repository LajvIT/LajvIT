<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelGroups extends JModelList {

  /**
   * Constructor.
   *
   * @param	array	An optional associative array of configuration settings.
   * @see		JController
   * @since	1.6
   */
  public function __construct($config = array()) {
    if (empty($config['filter_fields'])) {
      $config['filter_fields'] = array(
        'id', 'g.id',
        'name', 'g.name',
        'groupLeaderPersonId', 'g.groupLeaderPersonId',
        'maxParticipants', 'g.maxParticipants',
        'expectedParticipants', 'g.expectedParticipants',
        'status', 'g.status',
        'eventId', 'g.eventId',
      );
    }

    parent::__construct($config);
  }

  /**
   * Method to auto-populate the model state.
   *
   * Note. Calling getState in this method will result in recursion.
   *
   * @return	void
   * @since	1.6
   */
  protected function populateState($ordering = NULL, $direction = NULL) {
    // Initialise variables.
    $app = JFactory::getApplication();
    $session = JFactory::getSession();

    // Adjust the context to support modal layouts.
    if ($layout = JRequest::getVar('layout')) {
      $this->context .= '.'.$layout;
    }

    $event = $this->getUserStateFromRequest($this->context.'.filter.event', 'eid');
    $this->setState('filter.event', $event);

    // List state information.
    parent::populateState('g.name', 'asc');
  }

  /**
   * Method to get a store id based on model configuration state.
   *
   * This is necessary because the model is used by the component and
   * different modules that might need different sets of data or different
   * ordering requirements.
   *
   * @param	string		$id	A prefix for the store id.
   *
   * @return	string		A store id.
   * @since	1.6
   */
  protected function getStoreId($id = '') {
    $id .= ':' . $this->getState('group.groupId');

    return parent::getStoreId($id);
  }

  /**
   * Get the master query for retrieving a list of groups subject to the model state.
   *
   * @return	JDatabaseQuery
   * @since	1.6
   */
  function getListQuery() {
    $db = $this->getDbo();
    $query = $db->getQuery(TRUE);
    $user = JFactory::getUser();

    // Select the required fields from the table.
    $query->select(
      $this->getState(
        'list.select',
        'g.id, g.name, g.groupLeaderPersonId, g.description, g.maxParticipants, ' .
        'g.expectedParticipants, g.url, ' .
        'g.status, g.adminInformation, g.eventId, g.visible'
      )
    );

    $query->from('#__lit_groups AS g');

    $query->select('CONCAT(p.givenname, " ", p.surname) AS groupLeaderPersonName');
    $query->select('f.name AS factionName');
    $query->join('LEFT', '#__lit_person AS p ON p.id = g.groupLeaderPersonId');
    $query->join('LEFT', '#__lit_charafaction AS f ON f.id = g.factionId');

    if ($event = $this->getState('filter.event')) {
      $query->where('g.eventId = ' . (int) $event);
    }
    // Add the list ordering clause.
    //     $query->order($this->getState('list.ordering', 'g.ordering').' '.$this->getState('list.direction', 'ASC'));
    //     echo $query;
    return $query;
  }

  /**
   *
   * @param int $groupId
   * @return boolean|array
   */
  public function getGroups() {
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    return $group->getProperties();
  }

  public function getItems() {
    $items = parent::getItems();
    $user = JFactory::getUser();
    $userId = $user->get('id');
    $guest = $user->get('guest');
    $groups = $user->getAuthorisedViewLevels();

    foreach ($items as &$item) {
      if (!$guest) {
        $asset = 'com_lajvit.group.'.$item->id;

        // Check general edit permission first.
        if ($user->authorise('core.edit', $asset)) {
          // $item->params->set('access-edit', true);
          // Now check if edit.own is available.
        } elseif (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
          // Check for a valid user and that they are the owner.
          if ($userId == $item->groupLeaderPersonId) {
            // $item->params->set('access-edit', true);
          }
        }
      }

      // $access = $this->getState('filter.access');

      // if ($access) {
      //   // If the access filter has been set, we already have only the articles this user can view.
      //   $item->params->set('access-view', true);
      // }
      // else {
      //   // If no access filter is set, the layout takes some responsibility for display of limited information.
      //   if ($item->catid == 0 || $item->category_access === null) {
      //     $item->params->set('access-view', in_array($item->access, $groups));
      //   }
      //   else {
      //     $item->params->set('access-view', in_array($item->access, $groups) && in_array($item->category_access, $groups));
      //   }
      // }
    }

    return $items;
  }

}

