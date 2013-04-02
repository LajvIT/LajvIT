<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo $this->events[$this->eventid]->shortname; ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_UPDATE_CHARACTER'); ?></h1>

<p><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_DESCRIPTION'); ?></p>

<form action="index.php" method="post" enctype="multipart/form-data" name="characterEditForm">

<table>
<tbody>
<tr>
  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_NAME'); ?>:</td>
  <td>
    <div class="text"><?php echo $this->character->fullname; ?></div>
    <div class="icon edit_character"><a class="icon"
    href="index.php?option=com_lajvit&view=character&layout=editconcept&cid=<?php echo $this->character->id; ?>&eid=<?php echo $this->eventid; ?>&Itemid=<?php echo $this->itemid; ?>"
    title="<?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT'); ?>"></a></div>
  </td>

  <td rowspan="6">
<?php
if (!is_null($this->character->image)) {
  echo '    <img src="' . $this->character->image . '"/>';
} ?>
  </td>
</tr>

<tr>
  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_FACTION'); ?>:</td>
  <td><?php echo $this->character->factionname; ?></td>
</tr>

<tr>
  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CULTURE'); ?>:</td>
  <td><?php echo $this->character->culturename; ?></td>
</tr>

<tr>

  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CONCEPT'); ?>:</td>
  <td><?php echo $this->character->conceptname; ?></td>
</tr>

<tr>
  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_SPECIALISED_CONCEPT'); ?>:</td>
  <td><?php echo $this->character->concepttext; ?></td>
</tr>

<tr>
  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_AGE'); ?>:</td>
  <td>
    <input type="text" name="age" size="5" value="<?php echo $this->character->age; ?>"/>
  </td>
</tr>

<tr>
  <td></td>
  <td></td>
</tr>

<tr>
  <td><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_PHOTO'); ?>:</td>
  <td colspan="2">
    <input type="file" name="photo" size="25"/>
    (<?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_PHOTO_MAX_SIZE'); ?>.)
  </td>
</tr>

<?php
foreach ($this->character->groupMemberInfos as $groupData) {
  $group = $this->groupModel->getGroup($groupData->groupId);
  if ($group) {?>
<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS'); ?> (<?php echo $group['name']; ?>):</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="groupMemberInfo<?php echo $groupData->groupId?>" cols="70"
    rows="20"><?php echo $groupData->groupMemberInfo; ?></textarea>
  </td>
</tr><?php
  }
}

if (FALSE) { ?>
<tr>
  <td colspan="3">Beskrivning nivå 2 (För bekanta, grannar...):</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="description2" cols="70"
    rows="10"><?php echo $this->character->description2; ?></textarea>
  </td>
</tr>
<?php } ?>
<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS'); ?>:</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="description1" cols="70"
    rows="5"><?php echo $this->character->description1; ?></textarea>
  </td>
</tr>

<?php
foreach ($this->character->groupLeaderInfos as $groupData) {
  $group = $this->groupModel->getGroup($groupData->groupId);
  if ($group) {?>
<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_INFO_FOR_GROUPLEADER'); ?> (<?php echo $group['name']; ?>):</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="groupLeaderInfo<?php echo $groupData->groupId?>" cols="70"
    rows="10"><?php echo $groupData->groupLeaderInfo; ?></textarea>
  </td>
</tr><?php
  }
}?>

<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_PRIVATE'); ?>:</td>
</tr>
<tr>
  <td colspan="3">
  <textarea name="privateinfo" cols="70"
  rows="10"><?php echo $this->character->privateinfo; ?></textarea>
  </td>

</tr>

<tr>
  <td></td>
  <td>
    <input type="submit" value="<?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_SAVE'); ?>" title="save" />
  </td>
</tr>

<tr>
<td colspan="2">
<p><strong><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_EXPLANATION'); ?>:</strong></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_AGE'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS'); ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS_EXPLANATION'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS'); ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS_EXPLANATION'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_NOTE1'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_PRIVATE'); ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_PRIVATE_EXPLANATION'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_NOTE2'); ?></p>
</td>
</tr>

</tbody>
</table>

<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="save"/>
<input type="hidden" name="controller" value="character"/>
<input type="hidden" name="eid" value="<?php echo $this->eventid; ?>"/>
<input type="hidden" name="cid" value="<?php echo $this->characterid; ?>"/>
<input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>"/>

</form>
