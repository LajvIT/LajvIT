<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser(); ?>

<div class="group">
  <div class="container">
    <div class="eventName">Grupper</div><?php
$canDoEvent = EventHelper::getActions($this->eventId);
if ($this->eventId > 0 &&
    ($canDoEvent->get('core.edit') ||
        $this->groupModel->hasPersonApprovedCharacter($user->id, $this->eventId))) { ?>
    <div class="icon new_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=create&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" title="Ny grupp"></a></div><?php
} ?>
  </div>
</div>
<?php
$availableFactions = $this->lajvitModel->getCharacterFactions();
$visible = intval($this->state->get('filter.visible'));
$faction = intval($this->state->get('filter.faction'));
$status = $this->state->get('filter.status');
?>
<div class="group">
  <div class="container">
    <a href="index.php?option=com_lajvit&view=groups&visible=1&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $visible == 1 ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_VISIBLE'); ?></a>
    <a href="index.php?option=com_lajvit&view=groups&visible=0&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $visible == 0 ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_HIDDEN'); ?></a>
  </div>
  <div class="container"><?php
  foreach ($availableFactions as $availableFaction) { ?>
    <a href="index.php?option=com_lajvit&view=groups&faction=<?php
    echo $availableFaction->id; ?>&eid=<?php
    echo $this->eventId; ?>&Itemid=<?php
    echo $this->itemId; ?>" class="button <?php
    echo $faction == $availableFaction->id ? 'selected':''; ?>"><?php
    echo $availableFaction->name; ?></a><?php
  }
    ?>
  </div>
  <div class="container">
    <a href="index.php?option=com_lajvit&view=groups&status=created&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $status == 'created' ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_STATUS_CREATED'); ?></a>
    <a href="index.php?option=com_lajvit&view=groups&status=approved&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $status == 'approved' ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_STATUS_APPROVED'); ?></a>
    <a href="index.php?option=com_lajvit&view=groups&status=open&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $status == 'open' ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_STATUS_OPEN'); ?></a>
    <a href="index.php?option=com_lajvit&view=groups&status=closed&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $status == 'closed' ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_STATUS_CLOSED'); ?></a>
    <a href="index.php?option=com_lajvit&view=groups&status=rejected&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" class="button <?php echo $status == 'rejected' ? 'selected':''; ?>"><?php echo JText::_('COM_LAJVIT_GROUP_STATUS_REJECTED'); ?></a>
  </div>
</div>
<?php
if (isset($this->errorMsg) && $this->errorMsg != '') {
  echo '<div style="color: red; font-weight: bold;">' . JText::_($this->errorMsg) . '</div><br><br>';
}
if (isset($this->message) && $this->message != '') {
  if (isset($this->group)) {
    echo JText::_($this->message) . ": " . $this->group;
  } else {
    echo JText::_($this->message);
  }
  echo "<br><br>";
}

$visibleGroups = FALSE;
foreach ($this->items as $item) {
  $assetName = "com_lajvit.group." . $item->id;
  $canDo = GroupHelper::getActions($item->id);
  if ($item->visible == 1) {
    if ($canDo->get('core.edit') ||
        $canDo->get('core.edit.own') &&
        $this->groupModel->isPersonGroupLeaderForGroup($user->id, $item->id)) {

    } elseif ($canDo->get('lajvit.view.visible') && $item->status != 'open') {
      continue;
    } elseif ($canDo->get('lajvit.view.visible')) {

    } else {
      continue;
    }
  }
  if ($item->visible == 0 &&
      (!$canDo->get('lajvit.view.hidden') &&
          !($canDo->get('core.edit.own') &&
              $item->groupLeaderPersonId == $user->id))) {
    continue;
  }
  if (!$canDo->get('core.edit') &&
      !$this->groupModel->hasPersonApprovedCharacterInSameFaction($user, $item->id)) {
    continue;
  }
  $visibleGroups = TRUE;
?>
  <div class="group">
    <div class="container">
      <div class="infoText">
        <a href="index.php?option=com_lajvit&view=group&eid=<?php echo $this->eventId; ?>&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>">
        <?php echo $item->name; ?></a>
      </div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') &&
      $this->groupModel->isPersonGroupLeaderForGroup($user->id, $item->id)) { ?>
      <div class="icon edit_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=edit&eid=<?php echo $this->eventId; ?>&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_GROUP_EDIT'); ?>"></a></div>
      <div class="icon delete_group"><a class="icon" href="index.php?option=com_lajvit&controller=group&task=delete&eid=<?php echo $this->eventId; ?>&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_GROUP_REMOVE'); ?>"></a></div>
      <?php
  }
  ?>

      <div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_ADD_CHARACTER'); ?>"></a></div>
    </div>
    <div class="container">
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_LEADER'); ?>: <?php
      $first = TRUE;
      foreach ($item->groupLeaders as $groupLeader) {
        if (!$first) { echo ", "; }
        echo $groupLeader->groupLeaderPersonName;
        $first = FALSE;
      } ?></div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) { ?>
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_MAX_NO_MEMBERS');?>: <?php echo $item->maxParticipants; ?></div>
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_EXPECTED_NO_MEMBERS');?>: <?php echo $item->expectedParticipants; ?></div><?php
  } ?>

    </div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') &&
      $this->groupModel->isPersonGroupLeaderForGroup($user->id, $item->id)) { ?>
    <div class="container">
      <div class="text"><?php echo $item->url; ?></div>
    </div><?php
  } ?>
    <div class="container">
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_FACTION');?>: <?php echo $item->factionName; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_STATUS');?>: <?php echo JText::_('COM_LAJVIT_GROUP_STATUS_' . strtoupper($item->status)); ?></div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) { ?>
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_VISIBLE');?>: <?php echo $item->visible ? JText::_('COM_LAJVIT_YES') : JText::_('COM_LAJVIT_NO'); ?></div><?php
  } ?>
    </div>
    <div class="container">
      <div class="text"><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION');?>: <?php echo $item->descriptionPublic; ?></div>
    </div>
  </div>
<?php
}

if (!$visibleGroups) {
  echo JText::_('COM_LAJVIT_GROUP_NO_OPEN_GROUPS');
}
?>
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
