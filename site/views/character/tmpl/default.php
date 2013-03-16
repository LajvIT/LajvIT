<?php

// No direct access

defined('_JEXEC') or die('Restricted access');
$canDoOnEvent = EventHelper::getActions($this->eventid);
$user = JFactory::getUser();
// $canDoOnCharacter = CharacterHelper::getActions($this->character->id);
?>

<h1><?php echo $this->events[$this->eventid]->shortname; ?> - Karaktärsinfo</h1>

<table>
<tbody>
<tr>
  <td>Karaktärens namn:</td>
  <td><div class="text"><?php echo $this->character->fullname; ?></div><?php
  if ($canDoOnEvent->get('core.edit')) { ?>
    <div class="icon edit_character"><a class="icon" href="index.php?option=com_lajvit&view=character&layout=editconcept&cid=<?php echo $this->character->id; ?>&eid=<?php echo $this->eventid; ?>&Itemid=<?php echo $this->itemid; ?>" title="<?php echo JText::_('COM_LAJVIT_EDIT_CHARACTER'); ?>"></a></div><?php
  }
  ?>
  </td>

  <td rowspan="6">
<?php
if (!is_null($this->character->image)) {
  echo '    <img src="' . $this->character->image . '"/>';
} ?>
  </td>
</tr>

<tr>
  <td>Faktion:</td>
  <td><?php echo $this->character->factionname; ?></td>
</tr>

<tr>
  <td>Kultur:</td>
  <td><?php echo $this->character->culturename; ?></td>
</tr>

<tr>

  <td>Rollkoncept:</td>
  <td><?php echo $this->character->conceptname; ?></td>
</tr>

<tr>
  <td>Specialiserat rollkoncept:</td>
  <td><?php echo $this->character->concepttext; ?></td>
</tr>

<tr>
  <td>Ålder:</td>
  <td><?php echo $this->character->age; ?></td>
</tr>

<tr>
  <td>Grupper:</td>
  <td><?php
  $firstGroup = TRUE;
  foreach ($this->character->groupMemberships as $groupId) {
    $group = $this->groupModel->getGroup($groupId);
    if ($group) {
      if (!$firstGroup) {
        echo ", ";
      }
      echo $group['name'];
      $firstGroup = FALSE;
    }
  } ?></td>
</tr>

<tr>
  <td></td>
  <td></td>
</tr>

<?php
foreach ($this->character->groupMemberInfos as $groupData) {
  $group = $this->groupModel->getGroup($groupData->groupId);
  if ($canDoOnEvent->get('core.edit') ||
      ( $this->groupModel->isPersonGroupLeaderForGroup($user->id, $groupData->groupId) ||
        $this->groupModel->hasPersonCharacterInGroup($user->id, $groupData->groupId) && $canDoOnEvent->get('lajvit.char.groupmember')
      ) && $group) { ?>
  <tr>
    <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS'); ?>
    (<?php echo $group['name']; ?>):</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="groupMemberInfo<?php echo $groupData->groupId?>" cols="70" rows="20"
      disabled="disabled"><?php echo $groupData->groupMemberInfo; ?></textarea>
    </td>
  </tr><?php
  }
}?>

<?php  if (FALSE && ($this->role->character_view_lvl2 ||
    $canDoOnEvent->get('core.edit'))) { ?>
    <tr>
      <td colspan="3">Beskrivning nivå 2 (För bekanta, grannar...):</td>
    </tr>
    <tr>
      <td colspan="3">
        <textarea name="description2" cols="70" rows="10"
        disabled="disabled"><?php echo $this->character->description2; ?></textarea>
      </td>
    </tr>
<?php  } ?>

<?php  if ($this->role->character_view_lvl1 ||
    $canDoOnEvent->get('core.edit')) { ?>
  <tr>
    <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS'); ?>:</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="description1" cols="70" rows="5"
      disabled="disabled"><?php echo $this->character->description1; ?></textarea>
    </td>
  </tr>
<?php  } ?>

<?php
foreach ($this->character->groupLeaderInfos as $groupData) {
  $group = $this->groupModel->getGroup($groupData->groupId);
  if ($this->groupModel->isPersonGroupLeaderForGroup($user->id, $groupData->groupId)) { ?>
  <tr>
    <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_INFO_FOR_GROUPLEADER');?>
    (<?php echo $group['name'];?>):</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="groupLeaderInfo<?php echo $groupData->groupId?>" cols="70" rows="10"
      disabled="disabled"><?php echo $groupData->groupLeaderInfo; ?></textarea>
    </td>
  </tr><?php
  }
} ?>

<?php  if ($this->role->character_view_private ||
    $canDoOnEvent->get('core.edit')) { ?>
  <tr>
    <td colspan="3">Privat information (För spelaren, arrangörer och rollcoach):</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="privateinfo" cols="70" rows="10"
      disabled="disabled"><?php echo $this->character->privateinfo; ?></textarea>
    </td>

  </tr>
<?php  } ?>

</tbody>
</table>

