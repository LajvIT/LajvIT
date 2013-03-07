<?php
defined('_JEXEC') or die('Restricted access'); ?>

<div class="group">
  <div class="container">
    <div class="eventName">Grupper</div><?php
if ($this->eventId > 0) { ?>
    <div class="icon new_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=create&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>" title="Ny grupp"></a></div><?php
} ?>
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

$user = JFactory::getUser();
$visibleGroups = FALSE;
foreach ($this->items as $item) {
  $assetName = "com_lajvit.group." . $item->id;
  $canDo = GroupHelper::getActions($item->id);
  if ($item->visible == 1) {
    if ($canDo->get('core.edit') ||
        $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) {

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
        <a href="index.php?option=com_lajvit&view=group&groupId=<?php echo $item->id?>&Itemid=<?php echo $this->itemId; ?>">
        <?php echo $item->name; ?></a>
      </div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) { ?>
      <div class="icon edit_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=edit&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_GROUP_EDIT'); ?>"></a></div>
      <div class="icon delete_group"><a class="icon" href="index.php?option=com_lajvit&controller=group&task=delete&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_GROUP_REMOVE'); ?>"></a></div>
      <?php
  }
  ?>

      <div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=<?php echo $item->id; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_ADD_CHARACTER'); ?>"></a></div>
    </div>
    <div class="container">
      <div class="text">Gruppledare: <?php echo $item->groupLeaderPersonName;?></div>
      <div class="text">Max: <?php echo $item->maxParticipants; ?></div>
      <div class="text">Förväntat: <?php echo $item->expectedParticipants; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo $item->url; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo $item->description; ?></div>
    </div>
    <div class="container">
      <div class="text">Fraktion: <?php echo $item->factionName; ?></div>
    </div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) { ?>
    <div class="container">
      <div class="text">Synlig: <?php echo $item->visible ? 'Ja' : 'Nej'; ?></div>
      <div class="text">Status: <?php echo ucfirst($item->status); ?></div>
    </div><?php
  }
  ?>
  </div>
<?php
}

if (!$visibleGroups) {
  echo "Inga öppna grupper finns skapade i din fraktion";
}
?>
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
